<!-- resources/views/welcome.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Language Detection</title>
	@vite('resources/js/app.js')
</head>
<body>

<script type="text/javascript">
    var chk_userlanguage = function () {
        var baseLang = (navigator.userLanguage || navigator.language || "en").substring(0, 2).toLowerCase();
        console.log(baseLang);

        switch (baseLang) {
            case "de":
                alert('German');
                break;
            case "en":
                alert('English');
                break;
            case "ja":
                alert('Japanese');
                break;
            case "zh":
                alert('Chinese');
                break;
            default:
                alert('其他语言');
        }
		// 设置 baseLang Cookie
		$.cookie('baseLang', baseLang);
    };

    // 页面加载后运行检测函数
    window.onload = function() {
		// 设置名为 cookieName 的 Cookie
		//$.cookie('cookieName', 'cookieValue');
		chk_userlanguage();
        location.href="/";
		// 显示 cookieName 的值
		//alert($.cookie('cookieName'));
    }
</script>

</body>
</html>
