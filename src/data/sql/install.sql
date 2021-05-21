SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for epii_image
-- ----------------------------
CREATE TABLE IF NOT EXISTS `epii_image`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '图片表主键id',
  `photo_name` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '图片名称',
  `url` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '图片url',
  `description` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '描述',
  `note` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '备注',
  `create_time` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '图片表';

-- ----------------------------
-- Table structure for epii_log_making
-- ----------------------------
CREATE TABLE IF NOT EXISTS `epii_log_making`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '生成图片记录表主键id',
  `image_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '图片表外键id',
  `image_url` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '图片url',
  `template_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '模板表外键id',
  `template_name` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '模板名称',
  `template_url` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '模板表url',
  `result_image_url` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '结果图url',
  `create_time` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '生成图片记录表';

-- ----------------------------
-- Table structure for epii_tag
-- ----------------------------
CREATE TABLE IF NOT EXISTS `epii_tag`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '标签表主键id',
  `tag_name` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '标签名称',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '状态：0-禁用；1-启用',
  `create_time` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '标签表';

-- ----------------------------
-- Table structure for epii_template
-- ----------------------------
CREATE TABLE IF NOT EXISTS `epii_template`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '模板表主键id',
  `template_name` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '模板名称',
  `size_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '尺寸表外键id',
  `img` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '模板图片url(或src)',
  `position` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '可编辑区域范围',
  `create_time` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '模板表';

-- ----------------------------
-- Table structure for epii_template_tag
-- ----------------------------
CREATE TABLE IF NOT EXISTS `epii_template_tag`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '模板-标签表主键id',
  `template_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '模板表外键id',
  `tag_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '标签表外键id',
  `create_time` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '模板-标签表';

-- ----------------------------
-- Table structure for epii_frame
-- ----------------------------
CREATE TABLE IF NOT EXISTS `epii_frame`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '边框表主键id',
  `frame_name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '边框名称',
  `left_top_img` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '左上角图片',
  `top_img` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '上边缘图片',
  `right_top_img` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '右上角图片',
  `right_img` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '右边缘图片',
  `right_bottom_img` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '右下角图片',
  `bottom_img` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '下边缘图片',
  `left_bottom_img` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '左下角图片',
  `left_img` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '左边缘图片',
  `create_time` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '边框表';

SET FOREIGN_KEY_CHECKS = 1;
