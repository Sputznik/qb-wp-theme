# QB WP Theme Shortcodes

## `qb_themes` Shortcode

Displays a grid of all categories as theme tiles, using their custom background color, icon, and text color (if set via category custom fields).

### Usage

```
[qb_themes per_page="10"]
```

### Parameters

- `per_page` (optional): Number of categories to display. Default is `10`.

### Example

Display 6 categories:

```
[qb_themes per_page="6"]
```

### Output

- Each category is shown as a tile with:
  - Custom background color (`category_bg_color`)
  - Custom icon (`category_icon`)
  - Custom text/icon color (`category_text_color`)
  - Category name
  - Link to the category archive

---

For more details, see the code in `lib/shortcodes/qb-themes.php`.

### To show the single hero post on homepage by using orbit_query

Display 1 responsive post use:

```
[orbit_query style="hero" posts_per_page="1"]
```
