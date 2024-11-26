<?php
// Define the directory path
$directory = 'documents/';

// Check if the directory exists
if (is_dir($directory)) {
    // Set permissions to 755
    if (chmod($directory, 0755)) {
        echo "Permissions for '$directory' have been set to 755.";
    } else {
        echo "Failed to set permissions for '$directory'.";
    }
} else {
    echo "The directory '$directory' does not exist.";
}
?>
