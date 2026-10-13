# Miva — College Program Explorer

A small WordPress proof of concept built on top of the existing `miva` theme. An editor manages college programs in the admin; visitors browse them in a responsive directory. It demonstrates a classic PHP theme, a standalone plugin, a custom post type, Advanced Custom Fields integration and a custom Gutenberg block.

> The original `miva` theme is a practice clone of the Miva Open University scholarships landing page. This project is not affiliated with or endorsed by Miva Open University. All program content is fictional.

## Features

| Area | What it does | Where |
|---|---|---|
| Theme | Classic PHP theme: landing page, program directory, program detail page | `theme/` |
| Plugin | **College Programs**: owns the content model, independent of the theme | `custom-blocks/college-programs/` |
| Post type | `program`, with archive at `/programs/` and REST support | `includes/post-types.php` |
| ACF fields | Credential, campus, delivery mode, duration, application URL | `includes/fields.php` |
| Block | **Program Card**: pick a program, get a server-rendered card | `blocks/program-card/` |
| Block | **Call to Action**: a banner with a heading, a message and one button | `blocks/cta/` |
| Templates | `archive-program.php`, `single-program.php`, `template-parts/program-card.php` | `theme/` |
| Scholarships | `archive-scholarship.php`: card grid at `/scholarships/` with featured images; `single-scholarship.php`: detail page | `theme/` |

## Requirements

- WordPress 6.3 or later
- PHP 7.4 or later
- [Advanced Custom Fields](https://wordpress.org/plugins/advanced-custom-fields/) (the free version; no PRO features are used)

There is no build step and nothing to `npm install`.

The theme loads three things from public CDNs: Bootstrap 5.3.1 and animate.css 4.1.1 (both pinned, with Subresource Integrity hashes) and the Cinzel and Manrope fonts from Google Fonts.

## Quick start with WordPress Playground

This boots a disposable WordPress with the theme, the plugin, ACF and three sample programs. It needs Node.js only (no Docker, no database). From the repository root:

```bash
npx @wp-playground/cli@3.1.58 server \
  --login \
  --mount="$PWD/theme:/wordpress/wp-content/themes/miva" \
  --mount="$PWD/custom-blocks/college-programs:/wordpress/wp-content/plugins/college-programs" \
  --blueprint=./playground/blueprint.json
```

Then open <http://127.0.0.1:9400/programs/>. Nothing is persisted; stopping the command discards the site. The CLI asks for Node 24; it printed engine warnings but ran correctly on Node 22.12 during development.

## Installing in a real WordPress site

The theme and the plugin are separate packages in this repository: `theme/` and `custom-blocks/college-programs/`. Each is installed on its own, in either of two ways.

### Option A: upload zips in the admin

Build the two zips from the repository root:

```bash
mkdir -p dist
(cd theme && zip -rX ../dist/miva.zip . -x "*.DS_Store")
(cd custom-blocks && zip -rX ../dist/college-programs.zip college-programs -x "*.DS_Store")
```

1. **Theme**: Appearance → Themes → Add New → Upload Theme → choose `dist/miva.zip` → Activate **Miva Clone**.
2. **Plugin**: Plugins → Add New → Upload Plugin → choose `dist/college-programs.zip` → Activate **College Programs**.

Keep the zip named `miva.zip`: its files sit at the top level, so WordPress names the theme folder after the zip.

### Option B: copy or symlink the folders

```bash
# from the site's wp-content/ directory; REPO is the path to your clone
cp -R "$REPO/theme" themes/miva
cp -R "$REPO/custom-blocks/college-programs" plugins/college-programs
# or symlink instead, to keep the site in sync with the repository:
ln -s "$REPO/theme" themes/miva
ln -s "$REPO/custom-blocks/college-programs" plugins/college-programs
```

Then activate **Miva Clone** under Appearance → Themes and **College Programs** under Plugins.

### After activating

Activation registers the post type and flushes rewrite rules, so `/programs/` works straight away. If it returns a 404, visit Settings → Permalinks and press Save. Pretty permalinks must be enabled (any structure other than "Plain").

### ACF

Install and activate **Advanced Custom Fields** from Plugins → Add New. There is nothing to import: the plugin registers its field group in PHP with `acf_add_local_field_group()`, so a "Program details" box appears on every Program edit screen.

If ACF is not active, the site keeps working and an admin notice on the Plugins and Programs screens explains what is missing.

## Creating and viewing programs

1. Go to **Programs → Add New**.
2. Enter a title, some body content and an excerpt (the excerpt is the card summary).
3. Fill in **Program details** below the editor. Every field is optional.
4. Optionally set a program image (featured image).
5. Publish.

| Field | Name | Type |
|---|---|---|
| Credential | `program_credential` | Select: Certificate, Diploma, Degree |
| Campus | `program_campus` | Text |
| Delivery mode | `program_delivery_mode` | Select: On-campus, Online, Hybrid |
| Duration | `program_duration` | Text |
| Application URL | `program_application_url` | URL |

View the directory at `/programs/` and a single program at `/programs/<slug>/`. While the plugin is active the theme adds a "Programs" link to the main navigation.

Programs are also available from the standard REST route, with the five fields under `acf`. This is one item of real output from the test site:

```http
GET /wp-json/wp/v2/programs?_fields=id,title.rendered,acf
```

```json
{
  "id": 7,
  "title": { "rendered": "Bachelor of Business Analytics" },
  "acf": {
    "program_credential": "degree",
    "program_campus": "Northgate Campus",
    "program_delivery_mode": "on-campus",
    "program_duration": "4 years full-time",
    "program_application_url": "https://example.com/apply/business-analytics"
  }
}
```

No custom REST endpoints are added.

## Using the Program Card block

1. Edit any page or post and open the block inserter.
2. Search for **Program Card** (Widgets category).
3. Choose a program from the dropdown in the placeholder, or later from the block sidebar.

The editor shows the same markup visitors get, because the block is dynamic: `render.php` produces the card on every request and the editor previews it with `ServerSideRender`. Only the program ID is saved in post content, so edits to a program show up everywhere the card is used.

If the selected program is later trashed, unpublished or password-protected, visitors see nothing in its place and the editor shows a notice explaining why.

## Using the Call to Action block

A banner with a heading, a short message and one button. It is a native block and does not use ACF: ACF's own block builder is a PRO feature, and this project stays on ACF Free.

1. Edit any page or post and insert **Call to Action** (Widgets category).
2. Type the heading, the message and the button label directly in the banner.
3. Set **Button link** in the block sidebar. Leave it empty and the button links to the program directory.

Empty parts are left out: no heading tag without a heading, no button without a label.

**On the landing page.** `front-page.php` builds the landing page from fixed sections. To add the banner there, create a page, put the block in it, and choose that page under Settings → Reading → "Your homepage displays: A static page". Whatever the page contains is shown below the testimonials. The Playground blueprint sets this up.

## Architecture

```text
theme/                              the theme (presentation)
├── style.css, functions.php
├── header.php, footer.php, index.php, page.php, front-page.php
├── archive-program.php             program directory
├── single-program.php              program detail
├── archive-scholarship.php         scholarship grid
├── single-scholarship.php          scholarship detail
├── template-parts/
│   ├── program-card.php            card used by the directory
│   └── …                           landing page sections
├── inc/                            pre-existing scholarship/testimonial types
└── assets/, main.js

custom-blocks/college-programs/     the plugin (content and logic)
├── college-programs.php        header, includes, activation hooks
├── includes/
│   ├── post-types.php          `program` post type
│   ├── fields.php              ACF field group and missing-ACF notice
│   ├── template-functions.php  college_programs_get_program_data()
│   └── blocks.php              block registration
├── blocks/cta/                     same file layout as program-card
└── blocks/program-card/
    ├── block.json
    ├── index.js, index.asset.php   editor script (no build step)
    ├── render.php                  server-side markup
    └── style.css, editor.css

docs/screenshots/                   captures used in this README
```

**Why the split.** A program is content: it should still exist, be editable and be available over REST if the site changes theme. So the post type, the fields and the block live in the plugin. How a program looks on this particular site is the theme's job, so the archive and single templates live in the theme.

The two halves meet at one function, `college_programs_get_program_data( $post_id )`, which returns the five values already validated. The theme calls it behind `function_exists()`, so with the plugin switched off the theme still loads and simply has no program pages.

### Decisions worth knowing about

- *No build step.* The editor script is plain JavaScript on the `wp.*` globals with a hand-written `index.asset.php`. One small block did not justify a Node toolchain.
- *Fields are read with `get_post_meta()`, not `get_field()`.* ACF stores text, select and URL fields as ordinary post meta, so values that were already saved keep displaying if ACF is deactivated.
- *Two card markups.* The block ships its own neutral styles so it works in any theme; the directory uses the theme's Bootstrap card. They share data, not HTML.
- *`scholarship` and `testimonial` are still registered by the theme* (`inc/`). They predate this project and were left alone; `program` shows the preferred approach.

## Security, accessibility and responsive notes

### Security

- All output is escaped for its context (`esc_html`, `esc_attr`, `esc_url`); titles pass through `wp_kses_post`.
- The application URL is accepted only if it is `http` or `https` and has a host; anything else is treated as empty.
- Select values are mapped through the known choices, so an unexpected stored value is dropped rather than printed.
- Details of a password-protected program are withheld by the helper until the password is entered.
- The plugin adds no forms, admin actions, AJAX handlers, custom endpoints or SQL.

### Accessibility

- Skip link, a single `<main id="main">` landmark and corrected heading order.
- Visible `:focus-visible` outlines; a whole program card is outlined when its link has focus.
- Scroll animations are skipped for users who prefer reduced motion.
- The block's "Apply now" link includes the program title for screen readers.

### Responsive

- The program grid uses CSS Grid with `auto-fill`, so it needs no breakpoints.
- The landing page was fixed for small screens: previously `style.css` had no media queries and the "How it Works" section overflowed below 992px.

## Verification

Checks were run on 13 October 2026 against WordPress Playground: WordPress 7.1.3, PHP 8.3 (WebAssembly), SQLite, ACF 6.8.10, driven by headless Microsoft Edge (Chromium).

### Performed

- `php -l` on every PHP file under PHP 7.4.33 and 8.3.14: no errors.
- `block.json` parses; `index.js` passes `node --check`.
- Theme and plugin activate; landing page, directory, detail page and a page with the block load with `WP_DEBUG` on and no PHP notices.
- A program was created through the block editor, with all five ACF fields filled in through the meta box, then published. The values came back over REST and displayed on the detail page.
- The block was inserted on a new page, a program was chosen from its dropdown, the editor preview rendered, the page was published and the card appeared on the frontend.
- A program used in a block was trashed: the frontend showed no card and no error; the editor showed the notice.
- ACF deactivated: pages kept rendering the saved values and the admin notice appeared.
- College Programs deactivated: the site kept loading, the nav link disappeared, `/programs/` returned 404. After reactivation `/programs/` worked without re-saving permalinks.
- Malformed data written directly to post meta (`javascript:` and `ftp:` URLs, a URL without a host, an unknown credential value, HTML in the campus field, a `<script>` in the title, a draft, a password-protected program, a non-program ID and a missing ID in the block): nothing unsafe was output and nothing errored.
- No horizontal overflow on the landing page, directory, detail page or block page at 320, 375, 768 and 1280px wide.
- Call to Action block: inserted on a new page, heading, message and label typed into the banner, link set in the sidebar, published, and shown on the frontend. Reopening the page in the editor reported the block as valid.
- Call to Action on the landing page (static front page): rendered below the testimonials with no overflow at 320, 375, 768 and 1280px; with no link set, the button pointed at `/programs/`.
- Call to Action with hostile attributes (`<script>` and `<img onerror>` in the heading, a `javascript:` link in the message and as the button link): tags were stripped and the button fell back to the directory link.
- Zip install: `miva.zip` and `college-programs.zip`, built with the commands above, were installed and activated in a fresh site; the landing page, directory, detail page and block page loaded with no PHP notices.
- Scholarship archive: five sample scholarships (four with featured images, one without) rendered as 1, 2 and 3 columns at 375, 768 and 1280px with no overflow; the one without an image showed the placeholder panel.
- Scholarship detail page: cards link to it (the whole card is clickable and shows a focus outline); it showed the image, content, funder, amount and deadline, left out whatever was empty, and had no overflow at 320, 375, 768 and 1280px.
- Keyboard: tabbing through the directory reaches each card with a visible outline; the skip link receives focus and points at `#main`.

### Not performed

- No run on a conventional stack (Apache or Nginx, MySQL or MariaDB). Install steps for Local or MAMP above are written from knowledge of WordPress, not from a completed run.
- PHP 7.4 was linted only, not executed. WordPress 6.3, the stated minimum, was not run.
- Featured images on programs and archive pagination were not exercised (the sample data has no images and only a few programs).
- No screen reader, no physical devices, and no browser other than Chromium.
- No automated test suite, PHPCS or WordPress coding standards run.
- Whether the REST `acf` object is exposed for password-protected programs was not checked.

## Screenshots

Captured from the Playground site described above.

| | |
|---|---|
| Program directory | ![Program directory on desktop](docs/screenshots/program-archive-desktop.png) |
| Program detail | ![Program detail page on desktop](docs/screenshots/program-single-desktop.png) |
| Directory on a phone (375px) | ![Program directory at 375px](docs/screenshots/program-archive-mobile.png) |
| Detail on a phone (375px) | ![Program detail page at 375px](docs/screenshots/program-single-mobile.png) |
| ACF fields on a Program | ![Program details fields in the editor](docs/screenshots/program-fields.png) |
| Program Card in the editor | ![Program Card block selected in the block editor](docs/screenshots/block-editor.png) |
| Program Card on the frontend | ![Program Card block on a published page](docs/screenshots/block-frontend.png) |
| Call to Action in the editor | ![Call to Action block being edited](docs/screenshots/cta-editor.png) |
| Call to Action on the landing page | ![Call to Action banner above the footer](docs/screenshots/cta-landing-desktop.png) |
| Call to Action on a phone (375px) | ![Call to Action banner at 375px](docs/screenshots/cta-landing-mobile.png) |

## Known limitations and possible improvements

- The block's program picker lists the first 100 published programs alphabetically; a searchable picker would scale better.
- Most header and footer links are `#` placeholders, and the "Request Information" and "Apply Now" header buttons do nothing. They are inherited from the landing-page clone.
- The theme's `screenshot.png` is the hero photo, not a capture of the theme.
- Bootstrap, animate.css and the fonts come from CDNs; self-hosting them would remove the third-party requests.
- Campus is free text. If filtering by campus or credential were needed, taxonomies would be the better model.
- `scholarship` and `testimonial` could move into a plugin for the same reasons `program` lives in one.
- Strings are translation-ready, but no `.pot` file is included.

## License

GPL-2.0-or-later.
