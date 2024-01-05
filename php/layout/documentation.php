<div class="container">
    <div class="row">
        <div class="col">
            <h1>Documentation</h1>
            <h2>Installation</h2>
            <p>Download the code to your server. The easiest, especially to stay up to date, is to clone the repository to your server.</p>

            <h3>Requirements</h3>
            <p>RizeMeet uses <code>PHP</code> and the rewrite module. You may need to install these.</p>
            <p>RizeMeet uses multiple PHP packages. To install required packages you will need to use <b>composer</b> to retrieve the packages.</p>
            <p>If you have composer (if not, download it - google it) you can simply navigate to the RizeMeet directory in terminal run <code>composer update</code>.</p>

            <h3>In Browser</h3>
            <p>Visit your RizeMeet site in the browser to see the requirements are installed correctly. An 'empty' RizeMeet site should display.</p>
            <p>If the above is correct, visit the admin page. Simply add <code>/admin</code> to your site's URL. Alternatively you can click the <b>&pi;</b> symbol in the bottom right corner of the web page.</p>

            <h3>Administration</h3>
            <p>You are now in the administration area. The first task is to provide a username and password so that no one else can access this.</p>

            <p>You can customize the site's content here, as well as the meeting schedule.</p>

            <h3>Terminal again</h3>
            <p>Visiting the working site generates the <code>site/config.php</code> file. This is the file with the email, data system, and other settings are defined.</p>

            <p>The database option is not yet enabled.</p>

            <p>Setting the <code>SERVER_IS_PRODUCTION</code> to <code>TRUE</code> is recommended once everything appears to function.</p>

            <h2>Creating meeting locations</h2>
            <p>RizeMeet provides a meeting location template in the <code>site/rooms/</code>. Use this template to define new rooms/locations. You can combine these with uploaded images to show maps or any other images.</p>

        </div>
    </div>
</div>
