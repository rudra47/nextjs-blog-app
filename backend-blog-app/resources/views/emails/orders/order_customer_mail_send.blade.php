<html>


<body>
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
    <div marginwidth="0" marginheight="0">
        <div style="background-color:#f5f5f5;width:100%;margin:0;padding:70px 0 70px 0">
            <table height="100%" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                    <tr>
                        <td align="center" valign="top">
                            <div id="m_7710281554876410320template_header_image">
                            </div>
                            <table id="m_7710281554876410320template_container"
                                style="border-radius:6px!important;background-color:#fdfdfd;border:1px solid #dcdcdc;border-radius:6px!important"
                                border="0" cellpadding="0" cellspacing="0" width="600">
                                <tbody>
                                    <tr>
                                        <td align="center" valign="top">

                                            <table id="m_7710281554876410320template_header"
                                                style="background-color:#557da1;color:#ffffff;border-top-left-radius:6px!important;border-top-right-radius:6px!important;border-bottom:0;font-family:Arial;font-weight:bold;line-height:100%;vertical-align:middle"
                                                bgcolor="#557da1" border="0" cellpadding="0" cellspacing="0"
                                                width="600">
                                                <tbody>
                                                    <tr>
                                                        <td>


                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top">

                                            <table id="m_7710281554876410320template_body" border="0" cellpadding="0"
                                                cellspacing="0" width="600">
                                                <tbody>
                                                    <tr>
                                                        <td style="background-color:#fdfdfd;border-radius:6px!important"
                                                            valign="top">

                                                            <table border="0" cellpadding="20" cellspacing="0"
                                                                width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td valign="top">
                                                                            <div
                                                                                style="color:#737373;font-family:Arial;font-size:14px;line-height:150%;text-align:left">

                                                                                <p>THANK YOU and WELCOME!<br>
                                                                                    Your order has been received.<br>
                                                                                    Your order details are shown below.
                                                                                </p>

                                                                                <p>We have send you payment
                                                                                    instruction.Please check your
                                                                                    inbox.If you do not get it please
                                                                                    check your spam folder</p>


                                                                                <h2
                                                                                    style="color:#505050;display:block;font-family:Arial;font-size:36px;font-weight:bold;margin-top:10px;margin-right:0;margin-bottom:10px;margin-left:0;text-align:left;line-height:150%">
                                                                                    Order Number:
                                                                                    {{ "#".$order->order_no }}</h2>

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
                                                                                <h2
                                                                                    style="color:#505050;display:block;font-family:Arial;font-size:60px;font-weight:bold;margin-top:10px;margin-right:0;margin-bottom:10px;margin-left:0;text-align:left;line-height:150%">
                                                                                </h2>
                                                                                @if(!is_null($userInfos->additional_information))
                                                                                <p><strong>Note:</strong>
                                                                                    {{ $userInfos->additional_information }}
                                                                                </p>
                                                                                @endif

                                                                                <h2
                                                                                    style="color:#505050;display:block;font-family:Arial;font-size:60px;font-weight:bold;margin-top:10px;margin-right:0;margin-bottom:10px;margin-left:0;text-align:left;line-height:150%">
                                                                                    Customer details</h2>

                                                                                <p><strong>Email:</strong> <a
                                                                                        href="mailto:{{ $userInfos->email }}"
                                                                                        target="_blank">{{ $userInfos->email }}</a>
                                                                                </p>

                                                                                <table
                                                                                    style="width:100%;vertical-align:top"
                                                                                    border="0" cellpadding="0"
                                                                                    cellspacing="0">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td valign="top"
                                                                                                width="50%">

                                                                                                <h3
                                                                                                    style="color:#505050;display:block;font-family:Arial;font-size:26px;font-weight:bold;margin-top:10px;margin-right:0;margin-bottom:10px;margin-left:0;text-align:left;line-height:150%">
                                                                                                    Shipping address
                                                                                                </h3>

                                                                                                <p><br>
                                                                                                    {{ strtoupper($userInfos->first_name." ".$userInfos->last_name) }}<br>
                                                                                                    {{ !is_null($userInfos->company) ? strtoupper($userInfos->company) : ''  }}
                                                                                                    <br>{{ strtoupper($userInfos->address) }}
                                                                                                    {{ !is_null( $userInfos->apt) ? strtoupper($userInfos->apt): ''}}<br>{{ strtoupper($userInfos->city) }},
                                                                                                    {{ strtoupper($userInfos->state) }}
                                                                                                    {{ !is_null($userInfos->zip_code) ? strtoupper($userInfos->zip_code) :'' }}
                                                                                                </p>

                                                                                            </td>


                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
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
                                        <td align="center" valign="top">

                                            <table id="m_7710281554876410320template_footer" style="border-top:0"
                                                border="0" cellpadding="10" cellspacing="0" width="600">
                                                <tbody>
                                                    <tr>
                                                        <td valign="top">
                                                            <table border="0" cellpadding="10" cellspacing="0"
                                                                width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="2" id="m_7710281554876410320credit"
                                                                            style="border:0;color:#99b1c7;font-family:Arial;font-size:12px;line-height:125%;text-align:center"
                                                                            valign="middle">
                                                                            <b>
                                                                                <p
                                                                                    style="font-size: 20px; line-height: 27px">
                                                                                    <span
                                                                                        style="font-size: 25px; color: red;">Notice:</span><br>You
                                                                                    may escalate any customer service
                                                                                    case by using our new TICKET system.
                                                                                    <br>Click here <a href="{{ $domainName }}ticket">Ticket</a>
                                                                                    or find TICKET in the site menu</p>
                                                                            </b>

                                                                            <p>Powered by
                                                                                MONSTER</p>
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
                </tbody>
            </table>
        </div>
        <div class="yj6qo"></div>
        <div class="adL">
        </div>
    </div>
</body>

</html>
