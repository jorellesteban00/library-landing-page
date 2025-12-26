# Image Upload Implementation Guide

## Overview
This application uses a file-based image storage system for the WYSIWYG editor (Quill). When users insert images in page content, they are uploaded to the server and stored as files, not as base64-encoded data in the database.

## How It Works

### 1. Image Upload Flow
```
User clicks image button in Quill editor
  ↓
JavaScript triggers file input dialog
  ↓
User selects image
  ↓
JavaScript sends image via AJAX to server
  ↓
Laravel stores file in storage/app/public/page-images
  ↓
Server returns public URL
  ↓
Quill inserts image with URL in content
```

### 2. File Storage Location
- **Physical Path**: `storage/app/public/page-images/`
- **Public URL**: `storage/page-images/[filename]`
- **Symbolic Link**: Must exist from `public/storage` → `storage/app/public`

### 3. Key Components

#### Backend (PageController.php)
```php
public function uploadImage(Request $request)
{
    $request->validate([
        'file' => 'required|image|max:5120', // 5MB max
    ]);

    $path = $request->file('file')->store('page-images', 'public');

    return response()->json([
        'location' => asset('storage/' . $path)
    ]);
}
```

#### Frontend (Quill Editor)
- Custom image handler intercepts image insertions
- Uploads file via fetch API to `/staff/pages/upload-image`
- Displays "Uploading image..." while processing
- Embeds returned URL in content

#### Route
```php
Route::post('/pages/upload-image', [PageController::class, 'uploadImage'])
    ->name('pages.upload-image');
```

## Setup Requirements

### 1. Create Storage Symbolic Link
```bash
php artisan storage:link
```

This creates `public/storage` → `storage/app/public` symlink so uploaded files are accessible via web.

### 2. Set Correct Permissions
```bash
# Windows (run PowerShell as Administrator)
icacls "storage" /grant Users:F /t

# Linux/Mac
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### 3. Configure File Upload Limits

#### PHP Configuration (php.ini)
```ini
upload_max_filesize = 10M
post_max_size = 10M
max_file_uploads = 20
```

#### Laravel Validation
Current limit: **5MB per image** (configurable in `PageController@uploadImage`)

## Benefits of File-Based Storage

### ✅ Advantages
1. **Database Performance**: Content column stores only HTML with URLs, not massive base64 strings
2. **Storage Efficiency**: Images stored once, referenced multiple times
3. **CDN Ready**: Easy to migrate images to CDN later
4. **Caching**: Browsers cache images separately from page content
5. **Image Processing**: Can add thumbnails, optimization, etc.
6. **Backup**: Easier to create incremental backups

### ❌ Previous Base64 Issues
- Database bloat (65KB TEXT limit, 4GB LONGTEXT limit)
- Slower page loads
- Inefficient memory usage
- Harder to optimize/resize images
- Can't leverage browser caching

## Image Management

### Viewing Uploaded Images
All uploaded images are in:
```
storage/app/public/page-images/
```

### Cleaning Unused Images
When pages are deleted or images are removed from content, the files remain on disk. To clean up:

```php
// Future enhancement: Track image usage and delete orphaned files
// This would require building an image reference tracking system
```

## Future Enhancements

### 1. Image Optimization
Add automatic image compression and resizing:
```php
use Intervention\Image\Facades\Image;

public function uploadImage(Request $request)
{
    $image = Image::make($request->file('file'));
    $image->fit(1200, 1200, function ($constraint) {
        $constraint->aspectRatio();
        $constraint->upsize();
    });
    
    $filename = Str::random(40) . '.jpg';
    $path = 'page-images/' . $filename;
    
    Storage::disk('public')->put($path, $image->encode('jpg', 85));
    
    return response()->json([
        'location' => asset('storage/' . $path)
    ]);
}
```

### 2. Multiple Format Support
Generate WebP versions for modern browsers:
```php
$image->encode('webp', 85)->save($webpPath);
```

### 3. Thumbnail Generation
Create thumbnails for faster loading:
```php
$image->fit(400, 400)->save($thumbnailPath);
```

### 4. Image CDN Integration
Move images to AWS S3, Cloudinary, or similar:
```php
// Change disk to 's3' in .env
$path = $request->file('file')->store('page-images', 's3');
```

### 5. Image Reference Tracking
Track which pages use which images:
```php
// Create page_images table
Schema::create('page_images', function (Blueprint $table) {
    $table->id();
    $table->foreignId('page_id')->constrained()->onDelete('cascade');
    $table->string('image_path');
    $table->timestamps();
});

// Delete orphaned images when page is deleted
```

### 6. Image Lazy Loading
Add loading="lazy" attribute:
```javascript
quill.insertEmbed(range.index, 'image', {
    src: result.location,
    loading: 'lazy'
});
```

## Troubleshooting

### Images Not Showing
1. **Check symbolic link exists**:
   ```bash
   ls -la public/storage  # Should point to ../storage/app/public
   ```

2. **Verify file permissions**:
   ```bash
   # Storage directory should be writable
   ls -ld storage/app/public/page-images
   ```

3. **Check .env APP_URL**:
   ```env
   APP_URL=http://localhost:8000
   ```

### Upload Fails
1. **Check PHP limits**: `upload_max_filesize` and `post_max_size`
2. **Check Laravel logs**: `storage/logs/laravel.log`
3. **Verify CSRF token**: Ensure `_token` is sent with request

### Images Show Broken
1. **Check file exists**: Look in `storage/app/public/page-images/`
2. **Verify URL**: Should be `http://your-domain/storage/page-images/[filename]`
3. **Check APP_URL**: Matches your actual domain

## Security Considerations

### 1. File Type Validation
Current validation allows only images:
```php
'file' => 'required|image|max:5120'
```

### 2. File Size Limits
- Prevents DoS attacks via large uploads
- Current: 5MB per image

### 3. File Name Sanitization
Laravel automatically generates safe filenames:
```php
$path = $request->file('file')->store('page-images', 'public');
// Generates: page-images/xY7qwK3mN9pL2vB4.jpg
```

### 4. Directory Traversal Protection
Laravel's storage system prevents path traversal attacks

### 5. Public Access Control
Images in `storage/app/public` are publicly accessible once symlinked. For private images, use a different approach:
```php
// Store in storage/app/private-images (not public)
// Serve via controller with authentication check
```

## Monitoring & Maintenance

### Check Storage Usage
```bash
# Windows
dir storage\app\public\page-images /s

# Linux/Mac
du -sh storage/app/public/page-images
```

### Regular Maintenance
- Monitor disk space usage
- Backup images separately from database
- Consider implementing image cleanup for deleted pages
- Review and optimize large images periodically

## API Reference

### Upload Endpoint
```
POST /staff/pages/upload-image
Content-Type: multipart/form-data

Parameters:
  file: [image file] (required, max 5MB)
  _token: [CSRF token] (required)

Response (Success):
{
  "location": "http://your-domain/storage/page-images/abc123.jpg"
}

Response (Error):
{
  "message": "The file must be an image.",
  "errors": {
    "file": ["The file must be an image."]
  }
}
```

### Supported Image Types
- JPEG/JPG
- PNG
- GIF
- SVG
- WebP
- BMP

## Testing

### Manual Test
1. Navigate to Pages → Create New Page
2. Click image button in toolbar
3. Select an image file
4. Verify "Uploading image..." appears
5. Image should appear in editor
6. Save page and verify image persists
7. Check `storage/app/public/page-images/` for file

### Automated Test (Future)
```php
public function test_image_upload()
{
    Storage::fake('public');
    
    $file = UploadedFile::fake()->image('test.jpg', 600, 400);
    
    $response = $this->post('/staff/pages/upload-image', [
        'file' => $file,
    ]);
    
    $response->assertStatus(200);
    $response->assertJsonStructure(['location']);
    
    Storage::disk('public')->assertExists('page-images/' . $file->hashName());
}
```

## Migration Notes

### Previous Base64 Implementation
- Images were encoded as base64 strings
- Embedded directly in content column
- Caused database size issues
- Hit TEXT column 65KB limit

### Current File-Based Implementation
- Images stored as files
- Only URLs in content column
- Scalable and performant
- Industry standard approach

### Database Migration
The content column was upgraded from TEXT to LONGTEXT to handle edge cases, but with file-based storage, this is rarely needed:
```php
Schema::table('pages', function (Blueprint $table) {
    $table->longText('content')->change();
});
```

## Conclusion

The current implementation follows best practices for WYSIWYG image handling:
- ✅ Files stored on disk
- ✅ URLs in database
- ✅ Scalable architecture
- ✅ Browser cacheable
- ✅ CDN ready
- ✅ Secure validation

This approach will handle your library's content management needs efficiently and can scale as your content grows.
