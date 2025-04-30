<!DOCTYPE html>
<html>
<head>
    <title>Stream Download Demo</title>
</head>
<body>
    <h1>Demo Ekspor Data User</h1>

    <a href="/stream-download" download>
        <button>Download CSV (1000 Users)</button>
    </a>

    <p>File akan otomatis terdownload dengan nama: users-[tanggal].csv</p> <br>
    <p>nilai dari view composer : {{ $test_key }}</p> - {{ $appName }}
</body>
</html>
