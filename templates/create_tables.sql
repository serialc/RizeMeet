-- Create RIZEMEET table(s)

CREATE TABLE rizemeet_mailing_list (
    email VARCHAR(128) NOT NULL UNIQUE,
    created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (email)
);
