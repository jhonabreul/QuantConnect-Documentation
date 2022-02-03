<?php

function getSettlementText($brokerageName) {
    echo "<p>Trades through $brokerageName are settled immediately after the transaction.</p>"; 
}
getSettlementText("Oanda");

?>

<p>Backtesting nodes enable you to run backtests. The more backtesting nodes your organization has, the more concurrent backtests that you can run. Several models of backtesting nodes are available. Backtesting nodes that are more powerful can run faster backtests and backtest nodes with more RAM can handle more memory-intensive operations like training machine learning models, processing Options data, and managing large universes. The following table shows the specifications of the backtesting node models:<br></p>

<?php echo file_get_contents(DOCS_RESOURCES."/backtest-nodes-table.html"); ?>

<p>Refer to the <a href="/pricing">Pricing</a> page to see the price of each backtesting node model. You get one free B-MICRO backtesting node in your first organization. This node incurs a 20-second delay when you launch backtests, but the delay is removed and the node is replaced when you subscribe to a new backtesting node in the organization. Backtesting nodes are offered on a fair usage basis and can't be used for <a href='/docs/v2/our-platform/user-guides/optimization'>optimization</a>.</p>
