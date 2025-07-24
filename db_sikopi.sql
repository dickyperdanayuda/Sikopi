/*
 Navicat Premium Data Transfer

 Source Server         : Local
 Source Server Type    : MySQL
 Source Server Version : 50724
 Source Host           : localhost:3306
 Source Schema         : db_sikopi

 Target Server Type    : MySQL
 Target Server Version : 50724
 File Encoding         : 65001

 Date: 14/07/2022 14:15:36
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for barang
-- ----------------------------
DROP TABLE IF EXISTS `barang`;
CREATE TABLE `barang`  (
  `brg_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `brg_nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `brg_satuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `brg_jenis` int(11) NOT NULL,
  PRIMARY KEY (`brg_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of barang
-- ----------------------------
INSERT INTO `barang` VALUES (3, 'semen', 'Sak', 1);
INSERT INTO `barang` VALUES (5, 'Pasir', 'truk', 1);
INSERT INTO `barang` VALUES (12, 'Semen Acian Mortar Utama 250 @40kg', 'Sak', 1);
INSERT INTO `barang` VALUES (13, 'Seng ', 'Lusin', 1);
INSERT INTO `barang` VALUES (14, 'batu bara', 'truk', 1);

-- ----------------------------
-- Table structure for gudang
-- ----------------------------
DROP TABLE IF EXISTS `gudang`;
CREATE TABLE `gudang`  (
  `id_gudang` bigint(20) NOT NULL AUTO_INCREMENT,
  `nama_gudang` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat_gudang` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_gudang`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of gudang
-- ----------------------------
INSERT INTO `gudang` VALUES (2, 'Gudang Soetta', 'Jl. Soekarno Hatta 3');
INSERT INTO `gudang` VALUES (3, 'Panam', 'Jl. HR. Soebrantas');
INSERT INTO `gudang` VALUES (4, 'Gudang Lahan Wakaf', 'Jl. HR. Soebrantas Km 10');

-- ----------------------------
-- Table structure for pengajuan
-- ----------------------------
DROP TABLE IF EXISTS `pengajuan`;
CREATE TABLE `pengajuan`  (
  `pgj_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pgj_nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pgj_tgl` date NOT NULL,
  `pgj_status` smallint(1) NOT NULL,
  `pgj_status_ket` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pgj_id_prj` bigint(20) NOT NULL,
  `pgj_id_rq` bigint(20) NOT NULL,
  `pgj_id_gudang` bigint(11) NOT NULL,
  PRIMARY KEY (`pgj_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 106 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pengajuan
-- ----------------------------
INSERT INTO `pengajuan` VALUES (105, 'Pembuatan pondasi', '2022-07-08', 2, 'Selesai', 10, 35, 2);

-- ----------------------------
-- Table structure for pengajuan_detail
-- ----------------------------
DROP TABLE IF EXISTS `pengajuan_detail`;
CREATE TABLE `pengajuan_detail`  (
  `pgjd_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pgjd_brg_id` bigint(20) NOT NULL,
  `pgjd_pgj_id` bigint(20) NOT NULL,
  `pgjd_harga_satuan` int(11) NOT NULL,
  `pgjd_jml` int(11) NOT NULL,
  `pgjd_hrg_brg` int(11) NOT NULL,
  `pgjd_status` smallint(1) NOT NULL,
  PRIMARY KEY (`pgjd_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 72 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pengajuan_detail
-- ----------------------------
INSERT INTO `pengajuan_detail` VALUES (70, 5, 105, 10, 2, 20, 0);
INSERT INTO `pengajuan_detail` VALUES (71, 3, 105, 150, 5, 750, 0);

-- ----------------------------
-- Table structure for project
-- ----------------------------
DROP TABLE IF EXISTS `project`;
CREATE TABLE `project`  (
  `id_project` bigint(20) NOT NULL AUTO_INCREMENT,
  `tgl_project` date NOT NULL,
  `nama_project` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dp_id_gudang` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_project`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of project
-- ----------------------------
INSERT INTO `project` VALUES (4, '2022-05-29', 'Pembuatan TK Khoiru Ummah', '3');
INSERT INTO `project` VALUES (9, '2022-06-03', 'test21', '2,3');
INSERT INTO `project` VALUES (10, '2022-06-29', 'Pembuatan Tower', '3');
INSERT INTO `project` VALUES (11, '2022-06-10', 'Umum', '2');

-- ----------------------------
-- Table structure for purchase
-- ----------------------------
DROP TABLE IF EXISTS `purchase`;
CREATE TABLE `purchase`  (
  `prc_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `prc_tgl` date NOT NULL,
  `prc_nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `prc_status` smallint(1) NOT NULL,
  `prc_status_ket` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `prc_id_pgj` bigint(20) NULL DEFAULT NULL,
  `prc_nama_toko` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `prc_no_faktur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `prc_foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `prc_sumber` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`prc_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 27 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of purchase
-- ----------------------------
INSERT INTO `purchase` VALUES (16, '2022-07-08', 'Pembuatan pondasi', 1, 'Selesai', 105, 'sejahtera', '5355115', 'sejahtera.jpg', 'Pengajuan');
INSERT INTO `purchase` VALUES (26, '2022-07-14', 'Pembuatan parit', 3, 'Telah Diterima', NULL, NULL, NULL, NULL, 'Hamba Allah');

-- ----------------------------
-- Table structure for purchase_detail
-- ----------------------------
DROP TABLE IF EXISTS `purchase_detail`;
CREATE TABLE `purchase_detail`  (
  `prcd_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `prcd_brg_id` bigint(20) NOT NULL,
  `prcd_prc_id` bigint(20) NOT NULL,
  `prcd_harga_satuan` int(11) NOT NULL,
  `prcd_jml` int(11) NOT NULL,
  `prcd_hrg_brg` int(11) NOT NULL,
  PRIMARY KEY (`prcd_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 36 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of purchase_detail
-- ----------------------------
INSERT INTO `purchase_detail` VALUES (30, 5, 16, 10, 2, 20);
INSERT INTO `purchase_detail` VALUES (31, 3, 16, 150, 5, 750);
INSERT INTO `purchase_detail` VALUES (35, 3, 26, 1000, 10, 10000);

-- ----------------------------
-- Table structure for request
-- ----------------------------
DROP TABLE IF EXISTS `request`;
CREATE TABLE `request`  (
  `rq_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `rq_tgl` date NOT NULL,
  `rq_tgl_butuh` date NOT NULL,
  `rq_nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `rq_status` smallint(1) NOT NULL,
  `rq_status_ket` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_prj` bigint(20) NOT NULL,
  `rq_pic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `rq_id_gudang` bigint(11) NULL DEFAULT NULL,
  PRIMARY KEY (`rq_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 36 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of request
-- ----------------------------
INSERT INTO `request` VALUES (35, '2022-07-08', '2022-07-12', 'Pembuatan pondasi', 0, 'Diterima oleh gudang', 10, 'Pembuatan_pondasi.jpg', 2);

-- ----------------------------
-- Table structure for request_detail
-- ----------------------------
DROP TABLE IF EXISTS `request_detail`;
CREATE TABLE `request_detail`  (
  `rqd_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `rqd_rq_id` bigint(20) NOT NULL,
  `rqd_brg_id` bigint(20) NOT NULL,
  `rqd_harga_satuan` int(11) NOT NULL,
  `rqd_jml` int(11) NOT NULL,
  `rqd_hrg_brg` int(11) NOT NULL,
  `rqd_status` int(11) NOT NULL,
  PRIMARY KEY (`rqd_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 43 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of request_detail
-- ----------------------------
INSERT INTO `request_detail` VALUES (41, 35, 5, 10, 2, 20, 0);
INSERT INTO `request_detail` VALUES (42, 35, 3, 150, 5, 750, 0);

-- ----------------------------
-- Table structure for status_pengajuan
-- ----------------------------
DROP TABLE IF EXISTS `status_pengajuan`;
CREATE TABLE `status_pengajuan`  (
  `sp_id` int(11) NOT NULL AUTO_INCREMENT,
  `sp_id_pgjf` bigint(20) NOT NULL,
  `status_pgjf` smallint(1) NOT NULL,
  PRIMARY KEY (`sp_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 32 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of status_pengajuan
-- ----------------------------
INSERT INTO `status_pengajuan` VALUES (24, 16, 6);
INSERT INTO `status_pengajuan` VALUES (27, 22, 7);
INSERT INTO `status_pengajuan` VALUES (31, 26, 7);

-- ----------------------------
-- Table structure for stok
-- ----------------------------
DROP TABLE IF EXISTS `stok`;
CREATE TABLE `stok`  (
  `id_stok` bigint(11) NOT NULL AUTO_INCREMENT,
  `stk_id_brg` bigint(11) NULL DEFAULT NULL,
  `stk_id_prj` bigint(11) NULL DEFAULT NULL,
  `stk_jml` int(25) NULL DEFAULT NULL,
  `stk_kategori` smallint(1) NULL DEFAULT NULL,
  `stk_id_gudang` bigint(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id_stok`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of stok
-- ----------------------------
INSERT INTO `stok` VALUES (5, 5, 0, 4, 2, 2);
INSERT INTO `stok` VALUES (6, 3, 4, 36, 2, 3);
INSERT INTO `stok` VALUES (13, 12, 4, 2, 2, 2);
INSERT INTO `stok` VALUES (14, 13, 0, 12, 2, 2);
INSERT INTO `stok` VALUES (19, 5, 10, 2, 2, 2);
INSERT INTO `stok` VALUES (20, 3, 10, 5, 2, 2);
INSERT INTO `stok` VALUES (22, 3, 9, 46, 2, 2);

-- ----------------------------
-- Table structure for sys_login
-- ----------------------------
DROP TABLE IF EXISTS `sys_login`;
CREATE TABLE `sys_login`  (
  `log_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `log_user` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `log_pass` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `log_wa` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `log_level` smallint(3) NULL DEFAULT NULL,
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sys_login
-- ----------------------------
INSERT INTO `sys_login` VALUES (1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '', 1);
INSERT INTO `sys_login` VALUES (2, 'sv', '743541121c12a113af807d1582c74bea', '085155066010', 2);
INSERT INTO `sys_login` VALUES (3, 'pengelola', '3c7913bc17671596a43dcb4581992bdf', '', 2);
INSERT INTO `sys_login` VALUES (5, 'purchasing', '74ba4e8291e8b2e40a31a50505f8b72e', '', 4);
INSERT INTO `sys_login` VALUES (6, 'mandor', '707d803707c87747c71b0e5513ef73a9', '', 5);
INSERT INTO `sys_login` VALUES (7, 'direktur', '4fbfd324f5ffcdff5dbf6f019b02eca8', '0813', 6);
INSERT INTO `sys_login` VALUES (8, 'gudang', '202446dd1d6028084426867365b0c7a1', '1', 3);

SET FOREIGN_KEY_CHECKS = 1;
