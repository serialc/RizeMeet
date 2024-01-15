<?php
// Filename: php/classes/maillist.php
// Purpose: Handles load and manipulations of mailing list
// This can either create/modify a file or connect to a database depending
// on the site/config.php variable DATA_BACKEND_DB_OR_FILE

namespace frakturmedia\RizeMeet;

use PDO;

class MailingList {

    private $list;
    private $raw;
    private $sfc;
    private $conn;

    function __construct( )
    {
        switch (DATA_BACKEND_DB_OR_FILE) {
        case "db":
            // create connection, MySQL setup
            try {
                $this->conn = new PDO(
                    'mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME . ';charset=utf8',
                    DB_USER,
                    DB_PASS,
                    [PDO::MYSQL_ATTR_INIT_COMMAND =>"SET NAMES utf8;SET time_zone = '" . TIMEZONE . "'"]
                );
            } catch (PDOException $e) {
                // Database connection failed
                echo "Database connection failed" and die;
            }

            break;

        // default is file mode
        case "file":
        default:
            // check if it exists, create it if not
            if (!file_exists(MAILING_LIST_MEMBERS_FILENAME)) {
                touch(MAILING_LIST_MEMBERS_FILENAME);
            }

            // retrieve the data and trim any unexpected spaces or commas
            $this->raw = trim(file_get_contents(MAILING_LIST_MEMBERS_FILENAME), ', ');

            // remove any new lines if we find some
            $this->raw = str_replace(array("\n","\r\n","\r"), '', $this->raw);

            // if retrieved correctly
            if ($this->raw !== false) {
                // if empty, create empty array
                if ( strcmp($this->raw, '') === 0) {
                    $this->list= [];
                } else {
                    // transform from csv to list and remove any trailing spaces, commas
                    $this->list = explode(',', $this->raw);
                }
            } else {
                echo "Failed to open the mailing list file.";
                return false;
            }

            break;
        }

        // salt file, used to encyrpt email, check it exists and populate if not
        if (file_exists(ADMIN_SALT_FILE)) {
            $this->sfc = file_get_contents(ADMIN_SALT_FILE);
        } else {
            // no salt file exists, create one - generate a salt file code
            $this->sfc = generateRandomString(20);

            // save it
            file_put_contents(ADMIN_SALT_FILE, $this->sfc);
        }
    }

    public function saltAndHash ($email)
    {
        return hashPassword($this->sfc . $email);
    }

    public function verifyEmail ($email, $passed_hashed_email)
    {
        // note that we salt the password before hashing, so do that here
        return password_verify($this->sfc . $email, $passed_hashed_email);
    }

    public function count ()
    {
        switch (DATA_BACKEND_DB_OR_FILE) {
        case "db":
            $sql = "SELECT COUNT(*) AS count FROM " . TABLE_MAILINGLIST;
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([]);
            return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
            break;

        // default is file mode
        case "file":
        default:
            return count($this->list);
        }
    }

    private function save ()
    {
        switch (DATA_BACKEND_DB_OR_FILE) {
        case "db":
            // do nothing no need to 'save'
            break;

        // default is file mode
        case "file":
        default:
            if (!file_exists(MAILING_ARCHIVE_FOLDER)) {
                mkdir(MAILING_ARCHIVE_FOLDER);
            }

            # backup list
            file_put_contents(MAILING_ARCHIVE_FOLDER . 'ML_' . date('Y-m-d_H-i-s') . '.csv', $this->raw);

            # overwrite 
            file_put_contents(MAILING_LIST_MEMBERS_FILENAME, implode(',', $this->list));
        }
    }

    public function remove ($email)
    {
        switch (DATA_BACKEND_DB_OR_FILE) {
        case "db":
            $sql = "DELETE FROM " . TABLE_MAILINGLIST . " WHERE email=?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$email]);
            break;

        // default is file mode
        case "file":
        default:
            $index = array_search($email, $this->list);
            unset($this->list[$index]);
            $this->save();
        }
    }

    public function add ($email)
    {
        switch (DATA_BACKEND_DB_OR_FILE) {
        case "db":
            $sql = "INSERT IGNORE INTO " . TABLE_MAILINGLIST . "(email) VALUES (?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$email]);
            break;

        // default is file mode
        case "file":
        default:
            array_push($this->list, $email);
            $this->save();
        }
    }

    public function exists ($email)
    {
        switch (DATA_BACKEND_DB_OR_FILE) {
        case "db":
            $sql = "SELECT email FROM " . TABLE_MAILINGLIST . " WHERE email=?";
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute([$email]);
            if ($result && $stmt->rowCount() === 1) {
                return true;
            }
            break;

        // default is file mode
        case "file":
        default:
            if ( in_array($email, $this->list) ) {
                return true;
            }
        }

        return false;
    }

    public function getList ()
    {
        switch (DATA_BACKEND_DB_OR_FILE) {
        case "db":
            $sql = "SELECT email FROM " . TABLE_MAILINGLIST . "";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            $emails = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($emails, $row['email']);
            }
            return $emails;
            break;

        // default is file mode
        case "file":
        default:
            return $this->list;
        }
    }
}
