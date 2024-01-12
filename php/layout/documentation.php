<div class="container">
    <div class="row">
        <div class="col">
            <h1>Documentation</h1>
            <h2>Installation</h2>
            <p>Download the code to your server. The easiest, especially to stay up to date, is to clone the repository to your server.</p>

            <h3>Requirements</h3>
            <p>RizeMeet uses <code>PHP</code> and the rewrite module. You should confirm it's installed.</p>
            <p>You must provide a <code>www/.htaccess</code> file to enable rewrite. For my server the following .htaccess contents are used:<br>
<pre>
&lt;IfModule mod_rewrite.c&gt;
    RewriteEngine On
    RewriteBase /

# API like urls
    RewriteRule ^index\.php$ - [L]
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule .* index.php [L]
&lt;/IfModule&gt;
</pre>
</p>
            <p>RizeMeet uses multiple PHP packages. To install required packages you will need to use <b>Composer</b> to retrieve the packages.</p>
            <p>If you have Composer (if not, download it - google it) you can simply navigate to the RizeMeet directory in terminal run:
<pre><code>composer update</code></pre>
or:
<pre><code>php composer.phar update</code></pre></p>

            <h3>In Browser</h3>
            <p>Visit your RizeMeet site in the browser to see the requirements are installed correctly. The RizeMeet template site should display.</p>
            <p>If the above functions, visit the admin page. Simply add <code>/admin</code> to your site's URL. Alternatively you can click the <b>&pi;</b> symbol in the bottom right corner of the web page.</p>

            <h3>Administration</h3>
            <p>You are now in the administration area. The first task is to provide a username and password so that no one else can access this.</p>

            <p>You can customize the site's content here, as well as the meeting schedule.</p>

            <h3>Terminal again</h3>
            <p>Visiting the working site generates the <code>site/config.php</code> file. This is the file with the email, data storage system (file-based or database), and other settings are defined.</p>

            <p>Setting the <code>SERVER_IS_PRODUCTION</code> to <code>TRUE</code>, in the <code>site/config.php</code> is recommended once everything appears to function.</p>

        </div>
    </div>
</div>
