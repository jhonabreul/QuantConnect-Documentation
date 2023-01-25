<p>The following sections explain why each <code>OrderResponseErrorCode</code> occurs and how you can avoid it.</p>

<h4><a id='none'></a>None (0)</h4>

<p></p>


<h4><a id='processing-error'></a>Processing Error</h4>
<p>The <code>OrderResponseErrorCode.ProcessingError</code> (-1) error occurs in the following situations:</p>
<ul>
    <li>When you submit a new order, but LEAN throws an exception while checking if you have sufficient buying power for the order.</li>
    <li>When you try to update or cancel an order, but LEAN throws an exception.</li>
</ul>

<p>To investigate this issue further, see the <code>HandleSubmitOrderRequest</code>, <code>UpdateOrder</code>, and <code>CancelOrder</code> methods of the <a rel='nofollow' target='_blank' href='https://github.com/QuantConnect/Lean/blob/master/Engine/TransactionHandlers/BrokerageTransactionHandler.cs'>BrokerageTransactionHandler</a> in the LEAN GitHub repository.</p>


<h4><a id='order-already-exists'></a>Order Already Exists</h4>
<p>The <code>OrderResponseErrorCode.OrderAlreadyExists</code> (-2) error occurs when you submit a new order but you already have an open order or a completed order with the same order ID.</p>
<!-- How is this even possible? Can we reproduce it? --> 

<p>To avoid this error ...</p>


<h4><a id='insufficient-buying-power'></a>Insufficient Buying Power</h4>
<p>The <code>OrderResponseErrorCode.InsufficientBuyingPower</code> (-3) error occurs when you place an order for a quantity that the <a href='/docs/v2/writing-algorithms/reality-modeling/buying-power'>buying power model</a> determines you can't afford.</p>

<p>This error commonly occurs when you place a market on open order with daily data. If you place the order with <code>SetHoldings</code> or use <code>CalculateOrderQuantity</code> to determine the order quantity, LEAN calculates the order quantity based on the market close price. If the open price on the following day makes your order more expensive, then you may have insufficient buying power. To avoid issues, use intraday data and place trades when the market is open or <a href='/docs/v2/writing-algorithms/trading-and-orders/position-sizing#05-Buying-Power-Buffer'>adjust your buying power buffer</a>.</p>



<h4><a id='brokerage-model-refused-to-submit-order'></a>Brokerage Model Refused to Submit Order</h4>
<p>The <code>OrderResponseErrorCode.BrokerageModelRefusedToSubmitOrder</code> (-4) error occurs when the place an order but the <code>CanSubmitOrder</code> method of the brokerage model returns <code class='csharp'>false</code><code class='python'>False</code>. The <code>CanSubmitOrder</code> method usually checks the order you submit passes the following requirements before sending it to the brokerage:</p>

<ul>
    <li>Supported security types</li>
    <li>Supported order types and their respective requirements</li>
    <li>Supported time in force options</li>
    <li>The order size is larger than the minimum order size</li>
</ul>

<p>Each brokerage model can have additional order requirements that the brokerage declares. To avoid this order response error, see the following resources:</p>

<ul>
    <li>The <span class='page-section-name'>Orders</span> section of the <a href='/docs/v2/cloud-platform/live-trading/brokerages'>integration documentation for your brokerage</a></li>
    <li>The <code>CanSubmitOrder</code> method definition of your <a href='/docs/v2/writing-algorithms/reality-modeling/brokerages/supported-models'>brokerage model</a></li>
</ul>


<h4><a id='brokerage-failed-to-submit-order'></a>Brokerage Failed to Submit Order</h4>
<p>The <code>OrderResponseErrorCode.BrokerageFailedToSubmitOrder</code> (-5) error occurs when you place an order in an algorithm but the 
<code>PlaceOrder</code> method of the brokerage implementation either throws an error or returns <code class='csharp'>false</code><code class='python'>False</code>. As a result, the brokerage implementation fails to submit the order to your brokerage.</p>

<p>To investigate this order response error, see the <code>PlaceOrder</code> method definition of your <a href='/docs/v2/writing-algorithms/reality-modeling/brokerages/supported-models'>brokerage</a> or the <a rel='nofollow' target='_blank' href='https://github.com/QuantConnect/Lean/blob/master/Brokerages/Backtesting/BacktestingBrokerage.cs'>BacktestingBrokerage</a> in the LEAN GitHub repository.</p>


<h4><a id='brokerage-failed-to-update-order'></a>Brokerage Failed to Update Order</h4>
<p>The <code>OrderResponseErrorCode.BrokerageFailedToUpdateOrder</code> (-6) error occurs when you try to update an order but the <code>UpdateOrder</code> method of the brokerage implementation either throws an error or returns <code class='csharp'>false</code><code class='python'>False</code>. As a result, the brokerage implementation fails to submit the order update request to your brokerage.</p>

<p>To avoid this issue, see the <span class='page-section-name'>Orders</span> section of the <a href='/docs/v2/cloud-platform/live-trading/brokerages'>integration documentation for your brokerage</a> to check if your brokerage supports order updates.</p>

<p>To investigate this order response error, see the <code>UpdateOrder</code> method definition of your <a href='/docs/v2/writing-algorithms/reality-modeling/brokerages/supported-models'>brokerage</a> or the <a rel='nofollow' target='_blank' href='https://github.com/QuantConnect/Lean/blob/master/Brokerages/Backtesting/BacktestingBrokerage.cs'>BacktestingBrokerage</a> in the LEAN GitHub repository.</p>


<h4><a id='brokerage-handler-refused-to-update-order'></a>Brokerage Handler Refused to Update Order</h4>
<p>The <code>OrderResponseErrorCode.BrokerageHandlerRefusedToUpdateOrder</code> (-7) error is deprecated.</p>


<h4><a id='brokerage-failed-to-cancel-order'></a>Brokerage Failed to Cancel Order</h4>
<p>The <code>OrderResponseErrorCode.BrokerageFailedToCancelOrder</code> (-8) error occurs when you try to cancel an order but the <code>CancelOrder</code> method of the brokerage implementation either throws an error or returns <code class='csharp'>false</code><code class='python'>False</code>.</p>

<p>To investigate this order response error, see the <code>UpdateOrder</code> method definition of your <a href='/docs/v2/writing-algorithms/reality-modeling/brokerages/supported-models'>brokerage</a> or the <a rel='nofollow' target='_blank' href='https://github.com/QuantConnect/Lean/blob/master/Brokerages/Backtesting/BacktestingBrokerage.cs'>BacktestingBrokerage</a> in the LEAN GitHub repository.</p>


<h4><a id='invalid-order-status'></a>Invalid Order Status</h4>
<p>The <code>OrderResponseErrorCode.InvalidOrderStatus</code> (-9) error occurs when you try to update or cancel an order that's already complete. An order is complete if it has <code>OrderStatus.Filled</code>, <code>OrderStatus.Canceled</code>, or <code>OrderStatus.Invalid</code>.</p>

<p>To avoid this order response error, check <code>Status</code> of an <a href='/docs/v2/writing-algorithms/trading-and-orders/order-management/order-tickets'>order ticket</a> before you try to update the order.</p>


<h4><a id='unable-to-find-order'></a>Unable to Find Order</h4>
<p>The <code>OrderResponseErrorCode.UnableToFindOrder</code> (-10) error occurs when you try to place, update, or cancel an order, but the <code>BrokerageTransactionHandler</code> can't find the order ID in it's <code>_completeOrders</code> or <code>_completeOrderTickets</code> dictionaries.</p>

<p>To investigate this order response error, see <a rel='nofollow' target='_blank' href='https://github.com/QuantConnect/Lean/blob/master/Engine/TransactionHandlers/BrokerageTransactionHandler.cs'>BrokerageTransactionHandler.cs</a> in the LEAN GitHub repository.</p>


<h4><a id='order-quantity-zero'></a>Order Quantity Zero</h4>
<p>The <code>OrderResponseErrorCode.OrderQuantityZero</code> (-11) error occurs when you place an order that has zero quantity or when you update an order to have a zero quantity. This error commonly occurs if you use the <a href='/docs/v2/writing-algorithms/trading-and-orders/position-sizing'>SetHoldings</a> method but the portfolio weight you provide to the method is too small to translate into a non-zero order quantity.</p>

<p>To avoid this issue, check if the quantity of the order is non-zero before you place the order. If you use the <code>SetHoldings</code> method, consider replacing it with a combination of the <a href='/docs/v2/writing-algorithms/trading-and-orders/position-sizing#04-Calculate-Order-Quantities'>CalculateOrderQuantity</a> and <a href='/docs/v2/writing-algorithms/trading-and-orders/order-types/market-orders'>MarketOrder</a> methods.</p>

<div class="section-example-container">
<pre class="csharp">var quantity = CalculateOrderQuantity(_symbol, 0.05);
if (quantity != 0)
{
    MarketOrder(_symbol, quantity);
}</pre>
<pre class="python">quantity = self.CalculateOrderQuantity(self.symbol, 0.05)
if quantity:
    self.MarketOrder(self.symbol, quantity)</pre>
</div>


<h4><a id='unsupported-request-type'></a>Unsupported Request Type</h4>
<p>The <code>OrderResponseErrorCode.UnsupportedRequestType</code> (-12) error occurs in the following situations:</p>

<ul>
    <li>When you try to exercise an Option contract for which you hold a short position</li>
    <li>When you try to exercise an Option contract using a larger quantity than you hold</li>
</ul>

<p>To avoid this issue, check the quantity of your holdings before you try to exercise an Option contract.</p>

<div class="section-example-container">
<pre class="csharp">var holdingQuantity = Portfolio[_contractSymbol].Quantity;
if (holdingQuantity > 0)
{
    ExerciseOption(_contractSymbol, Math.Max(holdingQuantity, exerciseQuantity));
}</pre>
<pre class="python">holding_quantity = self.Portfolio[self.contract_symbol].Quantity
if holding_quantity > 0:
    self.ExerciseOption(self.contract_symbol, max(holding_quantity, exercise_quantity))</pre>
</div>


<h4><a id='pre-order-checks-error'></a>Pre-Order Checks Error</h4>
<p>The <code>OrderResponseErrorCode.PreOrderChecksError</code> (-13) error is deprecated.</p>


<h4><a id='missing-security'></a>Missing Security</h4>
<p>The <code>OrderResponseErrorCode.MissingSecurity</code> (-14) error occurs when you place an order for a security that you don't have a subscription for in your algorithm.</p>

<p>To avoid this issue, create a subscription for each security you want to trade in your algorithm. To create subscriptions, see the Requesting Data page of the <a href='/docs/v2/writing-algorithms/securities/asset-classes'>documentation for each asset class</a>.


<h4><a id='exchange-not-open'></a>Exchange Not Open</h4>
<p>The <code>OrderResponseErrorCode.ExchangeNotOpen</code> (-15) error occurs in the following situations:</p>

<ul>
    <li>When you try to exercise an Option when the exchange is not open</li>
    <li>When you try to place a market on open order for a Futures contract or a Future Option contract</li>
</ul>

<p>To avoid this issue, check if the exchange is open before you exercise an Option contract.</p>

<div class="section-example-container">
<pre class="csharp">if (IsMarketOpen(_contractSymbol))
{
    ExerciseOption(_contractSymbol, quantity);
}</pre>
<pre class="python">if self.IsMarketOpen(self.contract_symbol):
    self.ExerciseOption(self.contract_symbol, quantity)</pre>
</div>


<h4><a id='security-price-zero'></a>Security Price Zero</h4>
<p>The <code>OrderResponseErrorCode.SecurityPriceZero</code> (-16) error occurs when you place an order or exercise an Option contract when the security price is $0. The security price can be $0 for the following reasons:</p>

<ul>
    <li>The data is missing</li>
    <p>Investigate if it's a data issue. If it is a data issue, <a href='/docs/v2/cloud-platform/datasets/data-issues#04-Report-New-Issues'>report it</a>.</p>

    <li>The algorithm hasn't received data for the security yet</li>
    <p><?php echo file_get_contents(DOCS_RESOURCES."/initialization/zero-price-error.html"); ?>
</ul>



<h4><a id='forex-base-and-quote-currencies-required'></a>Forex Base and Quote Currencies Required</h4>
<p>The <code>OrderResponseErrorCode.ForexBaseAndQuoteCurrenciesRequired</code> (-17) error occurs when you place a trade for a Forex or Crypto pair when you don't have the base currency and <a href='/docs/v2/writing-algorithms/securities/key-concepts#03-Quote-Currency'>quote currency</a> in your <a href='/docs/v2/writing-algorithms/portfolio/cashbook'>cash book</a>.</p>


<h4><a id='forex-conversion-rate-zero'></a>Forex Conversion Rate Zero</h4>
<p>The <code>OrderResponseErrorCode.ForexConversionRateZero</code> (-18) error occurs when you place a trade for a Forex or Crypto pair and LEAN can't convert the value of the base currency to your account currency. This error usually indicators a lack of data. Investigate the data and if there is some missing, <a href='/docs/v2/cloud-platform/datasets/data-issues#04-Report-New-Issues'>report it</a>.</p>


<h4><a id='security-has-no-data'></a>Security Has No Data</h4>
<p>The <code>OrderResponseErrorCode.SecurityHasNoData</code> (-19) error occurs when you place an order for a security before your algorithm receives any data for it. <?php echo file_get_contents(DOCS_RESOURCES."/initialization/zero-price-error.html"); ?>




<h4><a id='exceeded-maximum-orders'></a>Exceeded Maximum Orders</h4>
<p>The <code>OrderResponseErrorCode.ExceededMaximumOrders</code> (-20) error occurs when exceed your order quota in a backtest. The number of orders you can place in a single backtest depends on the tier of your <a href='/docs/v2/cloud-platform/organizations/getting-started'>organization</a>. The following table shows the number of orders you can place on each tier:</p>

<?php echo file_get_contents(DOCS_RESOURCES."/quotas/orders.html"); ?>

<p>To avoid this order response error, reduce the number of orders in your backtest or <a href='/docs/v2/cloud-platform/organizations/billing#07-Change-Organization-Tiers'>upgrade your organization</a>.<br></p>


<h4><a id='market-on-close-order-too-late'></a>Market on Close Order Too Late</h4>
<p>The <code>OrderResponseErrorCode.MarketOnCloseOrderTooLate</code> (-21) error occurs when you try to place a market on close order before the market close time but you placed it too early in the trading day.</p>

<p>To avoid this order response error, place market on close orders closer to the market close or adjust the submission time buffer. <?php echo file_get_contents(DOCS_RESOURCES."/order-types/moc-buffer.html"); ?>


<h4><a id='invalid-request'></a>Invalid Request</h4>
<p>The <code>OrderResponseErrorCode.InvalidRequest</code> (-22) error occurs when you try to cancel an order multiple times.</p>

<p>To avoid this order response error, only try to cancel an order one time.</p>


<h4><a id='request-canceled'></a>Request Canceled</h4>
<p>The <code>OrderResponseErrorCode.RequestCanceled</code> (-23) error occurs when you try to cancel an order multiple times.</p>

<p>To avoid this order response error, only try to cancel an order one time.</p>


<h4><a id='algorithm-warming-up'></a>Algorithm Warming Up</h4>
<p>The <code>OrderResponseErrorCode.AlgorithmWarmingUp</code> (-24) error occurs in the following situations:</p>

<ul>
    <li>When you try to place, update, or cancel an order during the <a href='/docs/v2/writing-algorithms/historical-data/warm-up-periods'>warm-up period</a></li>
    <li>When the <a href='/docs/v2/writing-algorithms/trading-and-orders/order-types/option-exercise-orders#07-Option-Assignments'>Option assignment simulator</a> assigns you to an Option during the warm-up period</li>
</ul>

<p>To avoid this order response error, only manage orders after the warm-up period ends. To avoid trading during the warm-up period, add an <code>IsWarmingUp</code> guard to the top of the <code>OnData</code> method.</p>

<div class="section-example-container">
<pre class="csharp">if (IsWarmingUp) return;</pre>
<pre class="python">if self.IsWarmingUp: return</pre>
</div>


<h4><a id='brokerage-model-refused-to-update-order'></a>Brokerage Model Refused to Update Order</h4>
<p>The <code>OrderResponseErrorCode.BrokerageModelRefusedToUpdateOrder</code> (-25) error occurs in backtests when you try to update an order in a way that the <a href='/docs/v2/writing-algorithms/reality-modeling/brokerages/key-concepts'>brokerage model</a> doesn't support.</p>

<p>To avoid this issue, see the <span class='page-section-name'>Orders</span> section of the <a href='/docs/v2/cloud-platform/live-trading/brokerages'>integration documentation for your brokerage</a> to check its order requirements.</p>

<p>To investigate this order response error, see the <code>CanUpdateOrder</code> method definition of your <a href='/docs/v2/writing-algorithms/reality-modeling/brokerages/supported-models'>brokerage</a> or the <a rel='nofollow' target='_blank' href='https://github.com/QuantConnect/Lean/blob/master/Brokerages/Backtesting/BacktestingBrokerage.cs'>BacktestingBrokerage</a> in the LEAN GitHub repository.</p>



<h4><a id='quote-currency-required'></a>Quote Currency Required</h4>
<p>The <code>OrderResponseErrorCode.QuoteCurrencyRequired</code> (-26) error occurs when you place an order for a Forex or Crypto pair and don't have the <a href='/docs/v2/writing-algorithms/securities/key-concepts#03-Quote-Currency'>quote currency</a> of the pair in your <a href='/docs/v2/writing-algorithms/portfolio/cashbook'>cash book</a>.</p>


<h4><a id='conversion-rate-zero'></a>Conversion Rate Zero</h4>
<p>The <code>OrderResponseErrorCode.ConversionRateZero</code> (-27) error occurs when you place an order for a Forex or Crypto pair and LEAN can't convert the value of the <a href='/docs/v2/writing-algorithms/securities/key-concepts#03-Quote-Currency'>quote currency</a> in the pair to your account currency. This error can happen because of a lack of data. Investigate the data and if there is data missing, <a href='/docs/v2/cloud-platform/datasets/data-issues#04-Report-New-Issues'>report it</a>.</p>


<h4><a id='non-tradable-security'></a>Non-Tradable Security</h4>
<p>The <code>OrderResponseErrorCode.NonTradableSecurity</code> (-28) error occurs when you place an order for a security that's not <a href='/docs/v2/writing-algorithms/securities/key-concepts#07-Tradable-Status'>tradable</a>. To check if a security is tradable, use its <code>IsTradable</code> property.</p>

<div class="section-example-container">
    <pre class="csharp">var tradable = Securities[_symbol].IsTradable;</pre>
    <pre class="python">tradable = self.Securities[self.symbol].IsTradable</pre>
</div>


<h4><a id='non-exercisable-security'></a>Non-Exercisable Security</h4>
<p>The <code>OrderResponseErrorCode.NonExercisableSecurity</code> (-29) error occurs when you call the <a href='/docs/v2/writing-algorithms/trading-and-orders/order-types/option-exercise-orders'>ExerciseOption</a> method with a <code>Symbol</code> that doesn't reference an Option contract.</p>

<h4><a id='order-quantity-less-than-lot-size'></a>Order Quantity Less Than Lot Size</h4>
<p>The <code>OrderResponseErrorCode.OrderQuantityLessThanLoteSize</code> (-30) error occurs when you place an order with a quantity that's less than the lot size of the security.</p>

<p>To avoid this order response error, check if the order quantity is greater than or equal to the security lot size before you place an order.</p>

<div class="section-example-container">
    <pre class="csharp">var lotSize = Securities[_symbol].SymbolProperties.LotSize;
if (quantity >= lotSize)
{
    MarketOrder(_symbol, quantity);
}</pre>
    <pre class="python">lot_size = self.Securities[self.symbol].SymbolProperties.LotSize
if quantity >= lot_size:
    self.MarketOrder(self.symbol, quantity)</pre>
</div>


<h4><a id='exceeds-shortable-quantity'></a>Exceeds Shortable Quantity</h4>
<p>The <code>OrderResponseErrorCode.ExceedsShortableQuantity</code> (-31) error occurs when you place an order to short a security but the quantity you want to sell requires you to borrow shares from the brokerage and the shortable provider of the brokerage states that there isn't enough shares to borrow. For a full example of this error, clone and run <a href='https://www.quantconnect.com/terminal/processCache?request=embedded_backtest_e1834ede9a0efa6d134f87bd9fd30a70.html'>this backtest</a>.</p>

<p>To avoid this order response error, check if there are enough shares available before you place an order to short a security.</p>

<div class="section-example-container">
    <pre class="csharp">var availableToBorrow = BrokerageModel.GetShortableProvider().ShortableQuantity(_symbol, Time);
if (quantityToBorrow <= availableToBorrow)
{
    MarketOrder(_symbol, -quantityToBorrow);
}</pre>
    <pre class="python">available_to_borrow = self.BrokerageModel.GetShortableProvider().ShortableQuantity(self.symbol, self.Time)
if quantity_to_borrow <= available_to_borrow:
    self.MarketOrder(self.symbol, -quantity_to_borrow)</pre>
</div>


<h4><a id='invalid-new-order-status'></a>Invalid New Order Status</h4>
<p>The <code>OrderResponseErrorCode.InvalidNewOrderStatus</code> (-32) error occurs in live trading when you try to update or cancel an order while it still has <code>OrderStatus.New</code> status.</p>

<p>To avoid this order response error, check the <code>Status</code> property of the <a href='/docs/v2/writing-algorithms/trading-and-orders/order-management/order-tickets'>order ticket</a> before you update or cancel an order.</p>

<div class="section-example-container">
    <pre class="csharp">if (_orderTicket.Status != OrderStatus.New)
{
    _orderTicket.Cancel();
}</pre>
    <pre class="python">if self.order_ticket != OrderStatus.New:
    self.order_ticket.Cancel()</pre>
</div>

<h4><a id='european-option-not-expired-on-exercise'></a>European Option Not Expired on Exercise</h4>
<p>The <code>OrderResponseErrorCode.EuropeanOptionNotExpiredOnExercise</code> (-33) error occurs when you try to exercise a European Option contract before its expiry date.</p>

<p>To avoid this order response error, check the type and expiry date of the contract before you exercise it.</p>

<div class="section-example-container">
    <pre class="csharp">if (_contractSymbol.ID.OptionStyle == OptionStyle.European && _contractSymbol.ID.Date == Time.Date)
{
    ExerciseOption(_contractSymbol, quantity);
}</pre>
    <pre class="python">if (self.contract_symbol.ID.OptionStyle == OptionStyle.European && self.contract_symbol.ID.Date == self.Time.Date)
{
    self.ExerciseOption(self.contract_symbol, quantity);
}</pre>
</div>