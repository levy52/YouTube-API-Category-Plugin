# YouTube API Category Plugin

WordPress plugin that allows you to display the latest videos from a selected YouTube playlist in the category description. It uses the YouTube Data API to fetch the videos and display them in a responsive grid layout.

## Installation

1. Download the plugin files and upload them to your WordPress plugins directory (`/wp-content/plugins/`).
2. Activate the "YouTube API Category" plugin through the "Plugins" page in WordPress.

## Usage

1. Once the plugin is activated, you'll find a new menu item named "YouTube API Settings" under the "Settings" menu in the WordPress dashboard. Click on it to set your YouTube API key.
2. Enter your YouTube API key in the provided field and save the settings.
3. To display the YouTube playlist in a category description, use the following shortcode: `[youtube_playlist playlist_id="YOUR_PLAYLIST_ID" max_results="3"]`. Replace `YOUR_PLAYLIST_ID` with the actual playlist ID you want to display. The default value for `max_results` is 3, but you can change it to display more or fewer videos.
4. Insert the shortcode in the category description where you want the videos to be displayed.

## Shortcode Example

[youtube_playlist playlist_id="YOUR_PLAYLIST_ID" max_results="3"]

## Styling

You can customize the appearance of the videos by adding your own CSS rules. The plugin will automatically include the necessary CSS file to style the video layout.

## Requirements

- WordPress 4.0 or higher.
- PHP 5.6 or higher.

## Author

This plugin was developed by Radosław Lewicki. You can find the author's GitHub profile [here](https://github.com/levy52).

## License

This plugin is licensed under the GPLv2 or later license.

For more information, visit the [GitHub repository](https://github.com/levy52).