<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Page</title>
    <script src="https://widget.cloudinary.com/v2.0/global/all.js" type="text/javascript"></script>
</head>
<body>
    <h2>Payment for <?php echo htmlspecialchars($_GET['subscription']); ?> Plan</h2>
    <form method="POST" action="submit_payment.php">
        <input type="hidden" name="userId" value="<?php echo htmlspecialchars($_GET['userId']); ?>">
        <input type="hidden" name="paymentType" value="Apply Membership">
        <input type="hidden" name="subscription" value="<?php echo htmlspecialchars($_GET['subscription']); ?>">
        <input type="hidden" name="price" value="<?php echo htmlspecialchars($_GET['price']); ?>">

        <label for="paymentSlip">Upload Payment Slip:</label>
        <input type="file" id="paymentSlip" accept="image/*">
        <input type="hidden" name="paymentSlipUrl" id="paymentSlipUrl" required>
        
        <button type="button" onclick="uploadPaymentSlip()">Upload Payment Slip</button>
        <button type="submit">Submit Payment</button>
    </form>

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
    </script>
</body>
</html>
