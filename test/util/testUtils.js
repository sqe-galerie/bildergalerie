const mysql = require('mysql');
const fs = require('fs');
const path = require('path');

const sqlFilePath = './dbReset.sql';
const uploadsPath = '../../uploads';

module.exports = {
    resetDB: function () {
        // reset database by sql script
        fs.readFile(sqlFilePath, function (err, data) {
            if (err) {
                throw err;
            }

            const sqlQuery = data.toString();

            let connection = mysql.createConnection({
                host: 'localhost',
                user: 'homestead',
                password: 'secret',
                database: 'sqe_bildergalerie',
                multipleStatements: true
            });

            connection.connect();

            connection.query(sqlQuery, (err, result) => {
                if (err) {
                    throw err;
                }
            });

            connection.end();
        });
    },
    resetUploads: function () {
        // reset uploads directory
        fs.readdir(uploadsPath, (err, files) => {
            if (err) throw err;

            for (const file of files) {
                // remove all files except README.md
                if (file !== "README.md") {
                    fs.unlink(path.join(uploadsPath, file), err => {
                        if (err) throw err;
                    });
                }
            }
        });
    }
};