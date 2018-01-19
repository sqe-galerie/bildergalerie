const mysql = require('mysql');
const fs = require('fs');
const path = require('path');
const DB = require('./dbConfig.json');

const sqlFilePath = path.resolve(__dirname, './dbReset.sql');
const uploadsPath = path.resolve(__dirname, '../../uploads');

module.exports = {
    resetDB: function () {
        // reset database by sql script
        fs.readFile(sqlFilePath, function (err, data) {
            if (err) {
                throw err;
            }

            const sqlQuery = data.toString();

            let connection = mysql.createConnection({
                host: DB.host,
                user: DB.user,
                password: DB.password,
                database: DB.database,
                multipleStatements: true
            });

            connection.connect();

            connection.query(sqlQuery, (err) => {
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
                    fs.remove(path.join(uploadsPath, file), err => {
                        if (err) throw err;
                    });
                }
            }
        });
    }
};