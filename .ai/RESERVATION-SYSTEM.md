# Bright Autonomy Reservation System

Last updated: 2026-07-08

The "Reserve Your Place in Line" feature is business-critical and must survive the rebuild.

## Current Architecture

During cleanup, the reservation backend was moved from the old `bright` theme into a site-specific plugin:

`wp-content/plugins/bright-reservations/bright-reservations.php`

The new theme should render the form UI, but database creation, AJAX handling, validation, and email notifications should remain in a plugin or equivalent site-specific code. Do not put core reservation database logic only inside a replaceable theme.

## Database Tables

### `wp_reserve`

Stores the main reservation/contact record.

Expected columns:

| Column | Type | Notes |
| --- | --- | --- |
| `id` | int | primary key, auto increment |
| `date` | datetime | default current timestamp |
| `fname` | tinytext | first name |
| `lname` | tinytext | last name |
| `email` | varchar(100) | indexed |
| `position` | tinytext | job title/position |
| `golfcourse` | tinytext | golf course name |
| `address` | varchar(128) | golf course address |
| `phone` | tinytext | phone number |

### `wp_machines`

Stores fleet/machine rows tied to a reservation.

Expected columns:

| Column | Type | Notes |
| --- | --- | --- |
| `id` | int | primary key, auto increment |
| `reserve_id` | int | indexed, references `wp_reserve.id` |
| `make` | tinytext | machine make |
| `model` | tinytext | machine model |
| `type` | tinytext | machine type |
| `year` | tinytext | manufacturing year |

Known local counts at cleanup time:

- `wp_reserve`: 82 rows
- `wp_machines`: 180 rows

## AJAX Actions

The current frontend JS submits to WordPress `admin-ajax.php`.

Keep these action names for compatibility:

| Action | Purpose | Access |
| --- | --- | --- |
| `form_reserve_submition` | public reservation submit | logged-in and logged-out users |
| `save_user_submition` | admin/super-admin pre-save and share-link flow | super admin only |

Note the legacy misspelling: `submition`. Keep it unless all frontend code is updated at the same time.

## Required Nonce

Nonce action:

`reserve_form_submition`

Expected POST key:

`nonce`

The old template generated it as:

```php
wp_nonce_field( 'reserve_form_submition', 'nonce_field' );
```

The frontend then sent:

```js
nonce: jQuery('[name="nonce_field"]').val()
```

## Public Form Fields

Expected POST fields:

| POST key | Meaning |
| --- | --- |
| `registered` | `0` for new email, `1` for existing email/share-link flow |
| `email` | email address |
| `fname` | first name |
| `lname` | last name |
| `pos` | position |
| `golf` | golf course name |
| `address` | golf course address |
| `phone` | phone number |
| `makes` | serialized `make[]` list |
| `models` | serialized `model[]` list |
| `types` | serialized `type[]` list |
| `years` | serialized `year[]` list |

Machine type options used by the old form:

- Ball Picker
- Fairway Mower
- Green Mower
- Roller

## Email Notifications

Reservation submissions send an HTML email.

Recipients used during cleanup:

```text
marius@dianomix.com, ali@dianomix.com, reservations@bright-autonomy.com
```

Subject:

```text
Reserve My Place in Line
```

The email body includes contact fields and each submitted machine.

## Existing Lookup Flow

The old Reserve page supported URLs like:

```text
/reserve-my-place-in-line/?email=name@example.com
```

When an email was present, the form prefilled existing contact fields and added new machine rows to the existing reservation instead of creating a duplicate contact record.

The new form should preserve this behavior if the client still uses share links.

## Required Helper Functions

The previous backend exposed these functions:

```php
bright_get_reserve_by_email( $email )
bright_get_id_reserve_by_email( $email )
bright_is_email_registered( $email )
```

The new theme may use these helpers if the backend plugin is active.

## Rebuild Requirements

When rebuilding the reservation UI in this theme:

1. Keep the public URL `/reserve-my-place-in-line/`.
2. Render a form with the same business fields.
3. Include the nonce field for `reserve_form_submition`.
4. Submit to `admin-ajax.php` using `form_reserve_submition`.
5. Preserve the `?email=` prefill behavior.
6. Show a success state after submission.
7. Test that `wp_reserve` and `wp_machines` receive rows.
8. Test that notification emails send through WP Mail SMTP.

## Data Safety

Before touching production:

- Back up files and database.
- Export `wp_reserve` and `wp_machines`.
- Test on staging first.
- Do not drop or rename the reservation tables.
- Do not change AJAX action names unless the frontend and backend are updated together.

