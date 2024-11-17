<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Page</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to external CSS for styling -->
    <script src="https://widget.cloudinary.com/v2.0/global/all.js" type="text/javascript"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .payment-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .payment-header h2 {
            font-size: 28px;
            color: #2d3436;
        }

        .payment-header .plan-name {
            color: #00b894;
            font-weight: bold;
        }

        .payment-header .plan-description {
            font-size: 16px;
            color: #636e72;
        }

        .payment-form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .input-group {
            margin-bottom: 20px;
            width: 100%;
        }

        .input-label {
            font-size: 16px;
            color: #2d3436;
            margin-bottom: 8px;
            display: block;
        }

        .input-field {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #dfe6e9;
            margin-top: 8px;
            font-size: 14px;
            background-color: #f1f2f6;
        }

        .button-group {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .upload-btn, .submit-btn {
            padding: 12px 20px;
            background-color: #00b894;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .upload-btn:hover, .submit-btn:hover {
            background-color: #098f6e;
        }

        .submit-btn {
            background-color: #098f6e;
        }

        .submit-btn:disabled {
            background-color: #b2bec3;
            cursor: not-allowed;
        }

        .alert {
            margin-top: 20px;
            padding: 10px;
            background-color: #f39c12;
            color: #fff;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>

<?php include '../includes/header.php'; ?>

    <div class="container">
        <div class="payment-header">
            <h2>Payment for <span class="plan-name"><?php echo htmlspecialchars($_GET['subscription']); ?> Plan</span></h2>
            <p class="plan-description">Complete your payment and enjoy the benefits of your chosen membership plan.</p>
        </div>

        <div class="payment-form">
            <form method="POST" action="submit_payment.php">
                <input type="hidden" name="userId" value="<?php echo htmlspecialchars($_GET['userId']); ?>">
                <input type="hidden" name="paymentType" value="Apply Membership">
                <input type="hidden" name="subscription" value="<?php echo htmlspecialchars($_GET['subscription']); ?>">
                <input type="hidden" name="price" value="<?php echo htmlspecialchars($_GET['price']); ?>">

                <div class="input-group">
                    <label for="paymentSlip" class="input-label">Upload Payment Slip:</label>
                    <input type="file" id="paymentSlip" accept="image/*" class="input-field">
                    <input type="hidden" name="paymentSlipUrl" id="paymentSlipUrl" required>
                </div>

                <div class="button-group">
                    <button type="button" class="upload-btn" onclick="uploadPaymentSlip()">Upload Payment Slip</button>
                    <button type="submit" class="submit-btn" onclick="uploadPayment()">Submit Payment</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function uploadPaymentSlip() {
            const cloudName = 'dgecq2e6l';
            const uploadPreset = 'jmrpithq';

            const fileInput = document.getElementById('paymentSlip');
            const paymentSlipUrlInput = document.getElementById('paymentSlipUrl');

            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                const formData = new FormData();
                formData.append('file', file);
                formData.append('upload_preset', uploadPreset);

                fetch(`https://api.cloudinary.com/v1_1/${cloudName}/image/upload`, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    paymentSlipUrlInput.value = data.secure_url;
                    alert('Payment slip uploaded successfully!');
                })
                .catch(error => {
                    console.error('Error uploading payment slip:', error);
                    alert('Failed to upload payment slip.');
                });
            } else {
                alert('Please select a payment slip to upload.');
            }
        }

        function uploadPayment() {
            alert('Payment Submitted Successfully! Check your Payments to know Status.');
            window.location.href = '/membership.php'; // Redirect to membership page after clicking OK
        }
    </script>

</body>
</html>
