## nginx 服务器配置

```
server{       
	listen 80;
        server_name www.yii2study.one; # 域名
        index index.html index.php; # 入口文件
        root  /home/wwwroot/default/git/yii2-basic-study/web; # 访问根目录

        include enable-php.conf;

        location ~ .*\.(gif|jpg|jpeg|png|bmp|swf)$
        {
            expires      30d;
        }
	
	#rewrite ^/front/(.*)$      /index.php/front/$1 last;
        #rewrite ^(.*)$           /index.php?r=/$1 ;
	
	if (!-e $request_filename){
        	rewrite ^/(.*)$ /index.php last;
    	}        

        location ~ .*\.(js|css)?$
        {
            expires      12h;
        }

        location ~ /\.
        {
            deny all;
        }
	
        access_log off;
}

```