CREATE DATABASE perpustakaan;
USE perpustakaan;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    username VARCHAR(100),
    password VARCHAR(255),
    role ENUM('admin','user'),
    genre_favorit VARCHAR(100)
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    username VARCHAR(100),
    password VARCHAR(255),
    role ENUM('admin','user'),
    genre_favorit VARCHAR(100)
);

CREATE TABLE buku (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(150),
    pengarang VARCHAR(100),
    penerbit VARCHAR(100),
    tahun INT,
    stok INT,
    genre VARCHAR(100),
    foto VARCHAR(255)
);

INSERT INTO buku (id, judul, pengarang, penerbit, tahun, stok, genre, foto) VALUES
(1, 'Silence', 'Akiyoshi Rikako', 'Gramedia', 2020, 4, 'Teknologi', 'IMG-20260409-WA0025.jpg'),
(2, 'Chainsawman 1', 'Tatsuki Fujimoto', 'Gramedia', 2022, 10, 'Teknologi', 'IMG-20260409-WA0020.jpg'),
(3, 'Chainsawman 2', 'Tatsuki Fujimoto', 'Gramedia', 2005, 15, 'Novel', 'Chain.jpg'),
(4, 'Chainsawman 6', 'Tatsuki Fujimoto', 'Gramedia', 1980, 5, 'Novel', 'IMG-20260409-WA0023.jpg'),
(5, 'The Body In Library', 'Aghata Christie', 'Gramedia', 2018, 6, 'Sains', 'IMG-20260409-WA0017.jpg'),
(6, 'Burning Heat', 'Akiyoshi Rikako', 'Gramedia', 2017, 10, 'Sains', 'IMG-20260409-WA0024.jpg'),
(7, 'EVERYTHING BECOMES F', 'Akiyoshi Rikako', 'Gramedia', 2010, 10, 'Sejarah', 'IMG-20260409-WA0015.jpg'),
(8, 'Memory Of Glass', 'Akiyoshi Rikako', 'Gramedia', 2019, 5, 'Motivasi', 'MoG.jpg'),
(9, 'Nemesis', 'Aghata Christie', 'Gramedia', 2016, 5, 'Bisnis', 'Nemesis.jpg'),
(10, 'Evil Under The Sun', 'Aghata Christie', 'Gramedia', 2019, 2, 'Teknologi', 'IMG-20260409-WA0018.jpg'),
(14, 'Partners In Crime', 'Aghata Christie', 'Gramedia', 1999, 4, 'Novel', 'IMG-20260409-WA0014.jpg'),
(15, 'No Longer Human', 'Osamu Dazai', 'Gramedia', 1999, 3, 'Novel', 'IMG-20260409-WA0019.jpg');

CREATE TABLE transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    buku_id INT,
    tanggal_pinjam DATE,
    tanggal_kembali DATE,
    status ENUM('dipinjam','dikembalikan'),
    tanggal_jatuh_tempo DATE,
    denda INT,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (buku_id) REFERENCES buku(id)
);

CREATE TABLE wishlist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    buku_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (buku_id) REFERENCES buku(id)
); 