<?php
return array(
	//'配置项'=>'配置值'

	//模板资源文件路劲配置
	'TMPL_PARSE_STRING'  => array(
			 '__ADMIN__'  => __ROOT__.'/Public/Admin',
			 '__HOME__'   => __ROOT__.'/Public/Home',
             '__COMMON__' => __ROOT__.'/Public/common'
 	),
	
	/* 数据库设置 */
    'DB_DEPLOY_TYPE'        =>  1, // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'REDIS_AUTH'            =>'duanzonglai', //
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  '127.0.0.1', // 服务器地址
    'DB_NAME'               =>  'db_oa',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'root',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'oa_',    // 数据库表前缀

    //显示跟踪信息
    'SHOW_PAGE_TRACE'      => true,

    'DEFAULT_MODULE'        =>  'Admin',  // 默认模块

    //RBAC权限信息

    //角色
    'RBAC_ROLES'         => array(
            '1'  =>  '高层管理',
            '2'  =>  '中层领导',
            '3'  =>   '普通职员'
        ),

    //基于角色的权限管理
    'RBAC_ROLE_AUTHS' => array(
            '1'  =>  '*/*',
            '2'  =>  array('email/*','doc/*','user/*'),
            '3'  =>  array('email/*','knowledge/*')
        ),
);