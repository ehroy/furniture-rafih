<!DOCTYPE html>
<html>
<head>
    <title>Konfirmasi Pesanan</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;">
    <table align="center" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table width="600px" style="background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td align="center" style="padding: 20px 0;">
                            <h2 style="color: #333;">Terima Kasih atas Pesanan Anda! 🎉</h2>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 10px 30px;">
                            <p>Halo, <strong>{{ $order->buyer_email }}</strong>!</p>
                            <p>Berikut adalah detail pesanan Anda:</p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 10px 30px;">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td><strong>Order Number:</strong></td>
                                    <td>{{ $order->order_number }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Alamat Pengiriman:</strong></td>
                                    <td>{{ $order->shipping_address }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Produk -->
                    <tr>
                        <td style="padding: 20px 30px;">
                            <h3 style="color: #333;">🛍️ Detail Produk</h3>
                            <table width="100%" style="border-collapse: collapse;">
                                @foreach ($cart as $item)
                                <tr>
                                    <td style="padding: 10px; border-bottom: 1px solid #ddd;">
                                        <p><strong>Nama:</strong> {{ $item['name'] }}</p>
                                        <p><strong>image:</strong> {{ $item['image']}}</p>
                                        <p><strong>Jumlah:</strong> {{ $item['quantity'] }}</p>
                                        @if(isset($item['selectedColor']['name']))
                                            <p><strong>Warna:</strong> {{ $item['selectedColor']['name'] }}</p>
                                        @endif
                                        @if(isset($item['selectedWoods']['name']))
                                            <p><strong>Kayu:</strong> {{ $item['selectedWoods']['name'] }}</p>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    @php $setting = \App\Helpers\SettingsHelper::getSettings(); @endphp
                    <tr>
                        <td align="center" style="padding: 20px;">
                            <p style="color: #555;">Terima kasih telah berbelanja di toko kami! ❤️</p>
                            <a href={{$setting['domain']}} style="background-color: #ff6f61; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">Kunjungi Toko</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
