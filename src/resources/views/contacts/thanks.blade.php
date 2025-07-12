<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Form</title>
    <link rel="stylesheet" href="{{ asset('css/layouts/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/layouts/common.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/contacts/thanks.css') }}">
</head>
<body>
    <main>
        <div class="thanks__content">
            <div class="thanks__bg-text">Thank you</div>
            <div class="thanks__heading">
                <h2>お問い合わせありがとうございました</h2>
            </div>
            <form class="form" action="/" method="GET">
                <button type="submit" class="form__button-submit">HOME</button>
            </form>
        </div>
    </main>
</body>
</html>
