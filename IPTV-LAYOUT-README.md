# IPTV File Layout - Implementation Guide

This document explains the IPTV File Layout that duplicates your existing Application Reviews layout with modified field data.

## Files Created

1. **single-iptv-file.php** - The IPTV layout template (duplicate of single.php with field changes)
2. **iptv-functions-additions.php** - WordPress admin code for template selection and custom fields

## What Was Changed

### Field Mappings

The following field labels and data were changed from the Application Reviews layout:

| Original Field | IPTV Field | Example Data |
|---------------|------------|--------------|
| App Name | Playlist Name | Free adult iptv m3u playlist 26/10/2025 |
| Package Name | Type | XXX Adult |
| Category | Format | M3U |
| Version | Category | IPTV Codes |
| Minimum OS | *(Removed)* | - |
| Size | File Size | 64 KB |
| Downloads | Downloads | 1076433+ |
| Updated on | Last Updated | October 26, 2025 |
| Ratings | *(Removed)* | - |

### What Stayed the Same

- All layout structure
- All CSS styling
- All JavaScript functionality
- Download button behavior
- Download counter functionality
- Sidebar (Trending Now, Recent Updates, Recent Guides)
- Social sharing buttons
- Comments section
- Similar posts section

## Installation Instructions

### Step 1: Upload the Template File

1. Upload **single-iptv-file.php** to your theme directory (same location as single.php)

### Step 2: Add Functions to functions.php

1. Open your theme's **functions.php** file
2. Copy ALL the code from **iptv-functions-additions.php**
3. Paste it at the end of your functions.php file
4. Save the file

### Step 3: Use the IPTV Layout

#### Creating a New IPTV Post

1. Go to **Posts → Add New** in WordPress admin
2. Enter your post title (this becomes the "Playlist Name")
3. Add your featured image
4. Add your content/description

#### Enable IPTV Layout

1. In the post editor, look for the **"Template Selection"** meta box in the sidebar
2. Check the box "Use IPTV File Layout"

#### Fill in IPTV Fields

1. Scroll down to the **"IPTV File Information"** meta box
2. Fill in the fields:
   - **Type**: e.g., XXX Adult, Sports, Movies
   - **Format**: e.g., M3U, M3U8, XSPF
   - **Category**: e.g., IPTV Codes, Free IPTV
   - **File Size**: e.g., 64 KB, 2 MB
   - **Downloads**: e.g., 1076433+

3. **Note**: Playlist Name uses the post title. Last Updated uses the post's modified date automatically.

#### Publish

1. Click **Publish** or **Update**
2. View your post to see it using the IPTV File Layout

## Custom Field Names

If you need to access these fields in custom code, use these meta key names:

```php
_singlo_iptv_type         // Type field
_singlo_iptv_format       // Format field
_singlo_iptv_category     // Category field
_singlo_iptv_size         // File Size field
_singlo_iptv_downloads    // Downloads field
_singlo_use_iptv_template // Template toggle (yes/no)
```

## Switching Between Layouts

You can switch any post between the default Application Reviews layout and the IPTV File Layout:

1. Edit the post
2. Check or uncheck "Use IPTV File Layout" in the Template Selection box
3. Update the post

## Troubleshooting

### IPTV Layout Not Showing

- Make sure single-iptv-file.php is uploaded to your theme directory
- Verify you checked "Use IPTV File Layout" in the post editor
- Clear your site cache if using a caching plugin

### Meta Box Not Appearing

- Ensure you copied ALL the code from iptv-functions-additions.php to functions.php
- Check for PHP errors in your error log
- Make sure you're editing a "Post" (not a Page or Custom Post Type)

### Fields Not Saving

- Check that you clicked "Update" or "Publish" after filling in the fields
- Verify there are no PHP errors in your error log
- Ensure you have proper permissions to edit posts

## Support

If you need to modify the layout further, edit the **single-iptv-file.php** file. All changes are localized to this template file and won't affect your existing Application Reviews layout.
