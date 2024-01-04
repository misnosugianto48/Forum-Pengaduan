USE pengaduandb;

CREATE TABLE mahasiswa (
    id_mahasiswa INT IDENTITY(1,1) NOT NULL,
    nama VARCHAR(50) NOT NULL,
    nim VARCHAR(10) NOT NULL,
    email VARCHAR(20) NOT NULL,
    password VARCHAR(10) NOT NULL,
    PRIMARY KEY(id_mahasiswa)
);

CREATE TABLE petugas (
    id_petugas INT IDENTITY(1,1) NOT NULL,
    nip VARCHAR(10) NOT NULL,
    nama VARCHAR(50) NOT NULL,
    password VARCHAR(10) NOT NULL,
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

CREATE TABLE admin (
    id_admin INT IDENTITY(1,1) NOT NULL,
    username VARCHAR(10) NOT NULL,
    password VARCHAR(10) NOT NULL,
    PRIMARY KEY(id_admin)
);

INSERT INTO admin values(
    'Admin',
    'Admin123'
);

SELECT * FROM admin;