# Upload this WordPress project to GitHub (Windows)

## Option A — GitHub Desktop (recommended, no terminal)

1. Extract the `NORTHLINE-WordPress-Full-Source.zip` to a local folder.
2. Open **GitHub Desktop** → **File → Add local repository** → choose the extracted folder.
3. If GitHub Desktop says it is not a repository, select **Create a Repository Here**.
4. Set repository name to `northline-wordpress-showcase` and description to `Bespoke WordPress theme + companion plugin — custom PHP, Gutenberg, REST and original frontend design`.
5. **Commit to main**, then click **Publish repository** and make it **Public** (only if you are comfortable sharing the source).
6. On github.com, open the repo → **Settings → Pages** → branch `main`, folder `/docs` → **Save**.
7. When GitHub publishes the site, copy the URL from the Pages section. Usually:
   `https://YOUR-USERNAME.github.io/northline-wordpress-showcase/`
8. Update the placeholder in the README after verifying the real URL.

## Option B — Git command line

Run the following from the extracted directory. Replace `YOUR-USERNAME` with your own GitHub username. Create an empty repository on GitHub first.

```bash
git init
git add .
git commit -m "Add bespoke WordPress theme, companion plugin, and engineering demo"
git branch -M main
git remote add origin https://github.com/YOUR-USERNAME/northline-wordpress-showcase.git
git push -u origin main
```

After the push, set up **GitHub Pages** under **Settings → Pages** to serve `/docs` from `main`.

## What to send the hiring manager

- **GitHub source**: `https://github.com/YOUR-USERNAME/northline-wordpress-showcase`
- **Static visual preview**: `https://YOUR-USERNAME.github.io/northline-wordpress-showcase/`
- **Key PHP file**: `https://github.com/YOUR-USERNAME/northline-wordpress-showcase/blob/main/wp-content/plugins/northline-core/northline-core.php`

Explain that the visual preview is static and that the GitHub repo contains actual WordPress PHP theme and plugin code. **Do not represent fictional concept projects as customer work.**
