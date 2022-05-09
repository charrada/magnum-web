# Druid-ESPRIT/magnum-web

## Setting up the project

1. Clone the repository:

```bash
# Through HTTPS.
git clone https://github.com/Druid-ESPRIT/magnum-web.git
# Or SSH, if you have a key.
git clone git@github.com:Druid-ESPRIT/magnum-web.git
```

2. Run `composer update` to initialize the `vendor` directory.

**Option A**:

3. Start your HTTP server.
4. Navigate to where this project is located in your browser at `localhost:<PORT>/`.

**Option B**:

3. Start Symfony's built-in HTTP server:

```bash
# Replace 8000 with any available port.
php bin/console server:start localhost:8000
```

4. Visit `localhost:8000` in your browser.

5. Open up phpmyadmin, and import the [magnum.sql](.sql/magnum.sql) database.
