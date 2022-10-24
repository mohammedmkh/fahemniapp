<!DOCTYPE html>
<html>
<head>
    <!-- Other Tags -->

    <!-- Moyasar Styles -->
    <link rel="stylesheet" href="https://cdn.moyasar.com/mpf/1.5.6/moyasar.css">

    <!-- Moyasar Scripts -->
    <script src="https://polyfill.io/v3/polyfill.min.js?features=fetch"></script>
    <script src="https://cdn.moyasar.com/mpf/1.5.6/moyasar.js"></script>



</head>
<body>

<div class="mysr-form"></div>
<script>
    Moyasar.init({
        // Required
        // Specify where to render the form
        // Can be a valid CSS selector and a reference to a DOM element
        element: '.mysr-form',

        // Required
        // Amount in the smallest currency unit
        // For example:
        // 10 SAR = 10 * 100 Halalas
        // 10 KWD = 10 * 1000 Fils
        // 10 JPY = 10 JPY (Japanese Yen does not have fractions)
        amount: {{1 * 100}},

        // Required
        // Currency of the payment transation
        currency: 'SAR',

        // Required
        // A small description of the current payment process
        description: 'Fahemni Order #54360099',

        // Required
        publishable_api_key: 'pk_live_RMWHSkwjB16LRNhJXnmiWjGoNvh4kUuAVbd9f3UZ',
        //publishable_api_key: 'pk_test_o5fatRhyXvpwS7j5x8W3FsxcQm23hsQsDkZkiSBK',
        // Required
        // This URL is used to redirect the user when payment process has completed
        callback_url: 'http://app.fahemni.com/back',

        Default: ['creditcard', 'applepay'],
        methods: [
            'creditcard',
            'applepay'
        ],
        apple_pay: {
            country: 'SA',
            label: 'Fahemni App',
            validate_merchant_url: 'https://api.moyasar.com/v1/applepay/initiate',
        }
    });
</script>

</body>
</html>
