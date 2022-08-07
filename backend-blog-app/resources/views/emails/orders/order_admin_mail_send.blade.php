<html>
    <style>
        h4.package_title {
            margin: 6px 11px;
            text-decoration: underline;
        }

        ol.package_ol {
            margin: 0;
            margin-bottom: 0px;
            padding: 0 9px;
            margin-bottom: 4px;
            font-size: 13px;
        }

    </style>
<body>
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody>
            <tr>
                <td>
                    <table align="center" bgcolor="#ababab" border="0" cellpadding="1" cellspacing="0" width="100%">
                        <tbody>
                            <tr>
                                <td>
                                    <table align="center" border="0" cellpadding="3" cellspacing="0" width="100%">
                                        <tbody>
                                            <tr bgcolor="#ffffff">
                                                <td>
                                                    <table align="left" border="0" cellpadding="1" cellspacing="5">
                                                        <tbody>
                                                            <tr>
                                                                <td align="left"><br>
                                                                    <pre>New customer order

You have received an order from  {{ ucwords($userInfos->first_name." ".$userInfos->last_name) }}. Their order is as follows:

****************************************************

Order number:  {{ "#".$order->order_no }}
Order date: {{ \Carbon\Carbon::parse($order->created_at)->toDayDateTimeString() }}
<table
style="width:100%;border:1px solid #eee"
border="1" cellpadding="6"
cellspacing="0">
<thead>
    <tr>
        <th scope="col"
            style="text-align:left;border:1px solid #eee">
            Product
            {{ !is_null($order->package_id) ? ' / Packages': '' }}
        </th>
        <th scope="col"
            style="text-align:left;border:1px solid #eee">
            Quantity</th>
        <th scope="col"
            style="text-align:left;border:1px solid #eee">
            Price</th>
    </tr>
</thead>
<tbody>

    @forelse ($cartItems as $item )
    @if($item['cartType'] ==
    'product')
        <tr>

            <td
                style="text-align:left;vertical-align:middle;border:1px solid #eee;word-wrap:break-word">
                {{ $item['name'] }} (
                {{ ucwords($item['cartType']) }} )
                <br><small></small>
            </td>
            <td
                style="text-align:left;vertical-align:middle;border:1px solid #eee">
                {{ $item['quantity'] }}
            </td>
            <td
                style="text-align:left;vertical-align:middle;border:1px solid #eee">
                <span
                    class="m_7710281554876410320amount">${{ $item['price'] }}</span>
            </td>

        </tr>
        @if($item['offer_variation'] =='free' && count($item['offer_products']) > 0)
            <tr>
                @php
                $freeProduct =
                $item['offer_products'][0];

                @endphp

                <td
                    style="text-align:left;vertical-align:middle;border:1px solid #eee;word-wrap:break-word">
                    {{ $freeProduct['name'] }}
                    <br><small></small>
                </td>
                <td
                    style="text-align:left;vertical-align:middle;border:1px solid #eee">
                    {{  $freeProduct['quantity'] }}
                </td>
                <td
                    style="text-align:left;vertical-align:middle;border:1px solid #eee">
                    <span
                        class="m_7710281554876410320amount">Free</span>
                </td>

            </tr>
        @endif
    @else
        <tr>

            <td
                style="text-align:left;vertical-align:middle;border:1px solid #eee;word-wrap:break-word">
                {{ $item['name'] }}
                (
                {{ ucwords($item['cartType']) }} )
                <br><small></small>

                @if( count($item['package_products']) > 0)
                    <h4
                        class="package_title">
                        Package Products
                    </h4>
                    <ol class="package_ol">
                        @foreach ($item['package_products'] as $pro )
                        {{ $pro['name'] }} ( {{ $pro['quantity'] }} )
                        @endforeach


                    </ol>
                @endif



            </td>
            <td
                style="text-align:left;vertical-align:middle;border:1px solid #eee">
                {{ $item['quantity'] }}
            </td>
            <td
                style="text-align:left;vertical-align:middle;border:1px solid #eee">
                <span
                    class="m_7710281554876410320amount">${{ $item['price'] }}</span>
            </td>

        </tr>
    @if($item['offer_variation'] == 'free' &&  count($item['offer_products']) > 0)
        <tr>
            @php
            $freeProduct =
            $item['offer_products'][0];

            @endphp

            <td
                style="text-align:left;vertical-align:middle;border:1px solid #eee;word-wrap:break-word">
                {{ $freeProduct['name'] }}
                <br><small></small>
            </td>
            <td
                style="text-align:left;vertical-align:middle;border:1px solid #eee">
                {{  $freeProduct['quantity'] }}
            </td>
            <td
                style="text-align:left;vertical-align:middle;border:1px solid #eee">
                <span
                    class="m_7710281554876410320amount">Free</span>
            </td>

        </tr>
    @endif
    @endif
    @empty
@endforelse


</tbody>
<tfoot>
    <tr>
        <th scope="row" colspan="2"
            style="text-align:left;border:1px solid #eee;border-top-width:4px">
            Cart Subtotal:</th>
        <td
            style="text-align:left;border:1px solid #eee;border-top-width:4px">
            <span
                class="m_7710281554876410320amount">${{ $order->sub_total }}</span>
        </td>
    </tr>
    @if(!is_null($coupon))
    <tr>
        <th scope="row" colspan="2"
            style="text-align:left;border:1px solid #eee">
            Coupone({{ strtoupper($coupon->code) }})
        </th>
        <td
            style="text-align:left;border:1px solid #eee">
            <span
                class="m_7710281554876410320amount">
                {{ $coupon->discount_amount }}
                {{ $coupon->discount_type == 'percentage' ? '%':'Dollar' }}
        </td>
    </tr>
    @endif

    <tr>
        <th scope="row" colspan="2"
            style="text-align:left;border:1px solid #eee">
            Shipping:</th>
        <td
            style="text-align:left;border:1px solid #eee">
            <span
                class="m_7710281554876410320amount">
                @if($order->sub_total
                < $configurationData['avoid_shipping_charge_for']
                    )
                    +{{ $configurationData['shipping_charge'] }}
                    @else
                    +0
                    @endif

        </td>
    </tr>
    <tr>
        <th scope="row" colspan="2"
            style="text-align:left;border:1px solid #eee">
            Payment Method:</th>
        <td
            style="text-align:left;border:1px solid #eee">
            {{ $order->payment_method_name }}
        </td>
    </tr>
    <tr>
        <th scope="row" colspan="2"
            style="text-align:left;border:1px solid #eee">
            Order Total:</th>
        <td
            style="text-align:left;border:1px solid #eee">
            <span
                class="m_7710281554876410320amount">
                ${{ $order->grand_total }}
            </span>
        </td>
    </tr>
</tfoot>
</table>

Customer details<br>
Note:{{ !is_null($userInfos->additional_information) ? $userInfos->additional_information: '' }}<br>
Email:  <a href="/squirrelmail/src/compose.php?send_to={{ $userInfos->email }}">{{ $userInfos->email }}</a><br>
Board Id: {{ !is_null($userInfos->board_id) ? $userInfos->board_id : '' }}<br>

Shipping address:<br>
{{ strtoupper($userInfos->first_name." ".$userInfos->last_name) }}<br>{{ !is_null($userInfos->company) ? strtoupper($userInfos->company) : '' }}<br>{{ strtoupper($userInfos->address) }} {{ strtoupper($userInfos->apt) }}<br>{{ strtoupper($userInfos->city) }} {{strtoupper($userInfos->state) }} {{ strtoupper($userInfos->zip_code) }}


@if(!is_null($visaDetails))
****************************************************
Card Details:<br>
Phone number: {{$visaDetails->phone_number}}<br>
Card number: {{$visaDetails->card_number}}<br>
Expire date: {{$visaDetails->expire_month . '/' . $visaDetails->expire_year }}<br>
CVV: {{$visaDetails->cvv}}<br>

Billing address:<br>
{{$visaDetails->first_name." ".$visaDetails->last_name}}<br>{{ $visaDetails->address }}<br>{{ $visaDetails->city }} {{ $visaDetails->state }} {{ $visaDetails->zip_code }}
 @endif
****************************************************

Powered by MONSTER Gear

</pre>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2" height="5" bgcolor="#ffffff"></td>
            </tr>
            <tr>
                <td>
                    <table align="center" bgcolor="#ababab" border="0" cellpadding="1" cellspacing="0" width="100%">
                        <tbody>
                            <tr>
                                <td>
                                    <table align="center" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0"
                                        width="100%">
                                        <tbody>
                                            <tr>
                                                <td align="left" bgcolor="#ababab">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table align="center" bgcolor="#dcdcdc" border="0" cellpadding="2"
                                                        cellspacing="2" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td><a
                                                                        href="../src/view_text.php?mailbox=INBOX&amp;passed_id=10335&amp;startMessage=1&amp;override_type0=text&amp;override_type1=html&amp;ent_id=2"></a>
                                                                </td>
                                                                <td><small><b><small>k</small></b></small></td>
                                                                <td><small></small></td>
                                                                <td><small><b></b></small></td>
                                                                <td><small>&nbsp;<a
                                                                            href="../src/download.php?absolute_dl=true&amp;passed_id=10335&amp;mailbox=INBOX&amp;ent_id=2"></a><a
                                                                            href="../src/view_text.php?mailbox=INBOX&amp;passed_id=10335&amp;startMessage=1&amp;override_type0=text&amp;override_type1=html&amp;ent_id=2"></a></small>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2" height="5" bgcolor="#ffffff"></td>
            </tr>
        </tbody>
    </table>



</body>

</html>
