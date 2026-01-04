<?php

declare(strict_types=1);

const DB_HOST = 'localhost';
const DB_PORT = '3306'; // port MySQL MAMP
const DB_NAME = 'portfolio'; // nom exact de la DB dans phpMyAdmin
const DB_USERNAME = 'root';
const DB_PASSWORD = 'root';

function getConnexion(): PDO
{
    return new PDO(
        'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USERNAME,
        DB_PASSWORD,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    );
}
