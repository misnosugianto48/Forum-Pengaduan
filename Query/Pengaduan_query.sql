CREATE DATABASE pengaduan_db;

USE pengaduandb;

drop table mahasiswa;
CREATE TABLE mahasiswa (
    id_mahasiswa INT IDENTITY(1,1) NOT NULL,
    nama VARCHAR(50) NOT NULL,
    nim VARCHAR(10) NOT NULL,
    email VARCHAR(30) NOT NULL,
    username VARCHAR(30) NOT NULL,
    pwd VARCHAR(10) NOT NULL,
    level_user VARCHAR(10) NOT NULL DEFAULT 'Mahasiswa',
    PRIMARY KEY(id_mahasiswa)
);

INSERT INTO mahasiswa ( nama, nim, email, username, pwd)
VALUES
    ( 'John Doe', '123456789', 'john@gmail.com','john23', 'johndoe'),
    ( 'Jane Smith', '987654321', 'jane@gmail.com','jane12', 'janesmith');

CREATE TABLE petugas (
    id_petugas INT IDENTITY(1,1) NOT NULL,
    nip VARCHAR(10) NOT NULL,
    username VARCHAR(50) NOT NULL,
    pwd VARCHAR(10) NOT NULL,
    level_user VARCHAR(10) NOT NULL,
    PRIMARY KEY(id_petugas)
);

drop table pengaduan;
CREATE TABLE pengaduan (
    id_pengaduan INT IDENTITY(1,1) NOT NULL,
    id_mahasiswa INT NOT NULL,
    judul VARCHAR(50) NOT NULL,
    isi_pengaduan VARCHAR(255) NOT NULL,
    tanggal_pengaduan VARCHAR(20) NOT NULL,
    status_pengaduan VARCHAR(20) NOT NULL DEFAULT 'On Progress',
    id_petugas INT NULL,
    PRIMARY KEY(id_pengaduan),
    CONSTRAINT fk_pengaduan_mahasiswa FOREIGN KEY(id_mahasiswa) 
    REFERENCES mahasiswa(id_mahasiswa) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO pengaduan (id_mahasiswa, judul, isi_pengaduan, tanggal_pengaduan)
VALUES
    (1, 'Pengaduan A', 'Isi Pengaduan A', '2024-01-01'),
    (2, 'Pengaduan B', 'Isi Pengaduan B', '2024-02-01');

drop table tanggapan;
CREATE TABLE tanggapan (
    id_tanggapan INT IDENTITY(1,1) NOT NULL,
    id_pengaduan INT NOT NULL,
    id_petugas INT NOT NULL,
    isi_tanggapan VARCHAR(255) NOT NULL,
    tanggal_tanggapan VARCHAR(20) NOT NULL,
    PRIMARY KEY(id_tanggapan),
    CONSTRAINT fk_tanggapan_pengaduan FOREIGN KEY(id_pengaduan) 
    REFERENCES pengaduan(id_pengaduan) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_tanggapan_petugas FOREIGN KEY(id_petugas) 
    REFERENCES petugas(id_petugas) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Dummy data untuk tabel tanggapan
INSERT INTO tanggapan (id_pengaduan, id_petugas, isi_tanggapan, tanggal_tanggapan)
VALUES
    (1, 2, 'Tanggapan A', '2024-01-02'),
    (2, 2, 'Tanggapan B', '2024-02-02');


CREATE TABLE admin (
    id_admin INT IDENTITY(1,1) NOT NULL,
    username VARCHAR(10) NOT NULL,
    pwd VARCHAR(10) NOT NULL,
    level_user VARCHAR(10) NOT NULL,
    PRIMARY KEY(id_admin)
);

INSERT INTO admin values(
    'Admin',
    'Admin123',
    'Admin'
);

insert into petugas values(
    '1402378',
    'Nama Petugas',
    '12345356',
    'Petugas'
);

SELECT * FROM petugas;
SELECT * FROM pengaduan;
SELECT * FROM tanggapan;
SELECT * FROM mahasiswa;

SELECT * FROM admin;

SELECT pengaduan.*, mahasiswa.nama, petugas.username 
                      FROM pengaduan 
                      LEFT JOIN mahasiswa ON pengaduan.id_mahasiswa = mahasiswa.id_mahasiswa
                      INNER JOIN petugas ON pengaduan.id_petugas = petugas.id_petugas 
                      ORDER BY id_pengaduan DESC;

                      SELECT pengaduan.*, mahasiswa.nama AS nama_mahasiswa, petugas.username AS username_petugas
FROM pengaduan 
LEFT JOIN mahasiswa ON pengaduan.id_mahasiswa = mahasiswa.id_mahasiswa
INNER JOIN petugas ON pengaduan.id_petugas = petugas.id_petugas 
ORDER BY id_pengaduan DESC;

SELECT pengaduan.*, mahasiswa.username FROM pengaduan RIGHT JOIN mahasiswa ON pengaduan.id_mahasiswa = mahasiswa.id_mahasiswa ORDER BY id_pengaduan DESC

select DISTINCT email from mahasiswa

SELECT pengaduan.*, mahasiswa.username 
                      FROM pengaduan 
                      LEFT JOIN mahasiswa ON pengaduan.id_mahasiswa = mahasiswa.id_mahasiswa 
                      WHERE status_pengaduan = 'On Progres'
                      ORDER BY id_pengaduan DESC;

SELECT COUNT(*) AS total_menanggapi  FROM tanggapan WHERE id_petugas = 2

SELECT COUNT(*) AS total_ditanggapi , pengaduan.id_mahasiswa FROM tanggapan 
INNER JOIN pengaduan ON tanggapan.id_pengaduan = pengaduan.id_pengaduan
 WHERE id_mahasiswa = 3