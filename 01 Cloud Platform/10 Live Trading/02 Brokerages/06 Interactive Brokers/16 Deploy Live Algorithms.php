<p>You must have an available <a href="/docs/v2/cloud-platform/organizations/resources#04-Live-Trading-Nodes">live trading node</a> for each live trading algorithm you deploy.<br></p>

<p>Follow these steps to deploy a live algorithm:</p>

<ol>
    <li><a href="/docs/v2/cloud-platform/projects/getting-started#02-View-All-Projects">Open the project</a> that you want to deploy.</li>
    <li>Click the <img class="inline-icon" src="https://cdn.quantconnect.com/i/tu/deploy-live-icon.png" alt="Lightning icon"> <span class="icon-name">Deploy Live</span> icon.</li>
    <li>On the Deploy Live page, click the <span class="field-name">Brokerage</span> field and then click <span class="button-name">Interactive Brokers</span> from the drop-down menu.</li>

    <? include(DOCS_RESOURCES."/brokerages/interactive-brokers/deploy-steps.php"); ?>

    <li>Click the <span class="field-name">Node</span> field and then click the live trading node that you want to use from the drop-down menu.</li>
    <li><span class="qualifier">(Optional)</span> <a href="/docs/v2/cloud-platform/live-trading/notifications">Set up notifications</a>.</li>
    <li>Configure the <span class="box-name">Automatically restart algorithm</span> setting.</li>
    <p>By enabling automatic restarts, the algorithm will use best efforts to restart the algorithm if it fails due to a runtime error. This can help improve the algorithm's resilience to temporary outages such as a brokerage API disconnection.</p>
    <li>Click <span class="button-name">Deploy</span>.</li>
    <li>If your IB account has 2FA enabled, tap the notification on your IB Key device and then enter your pin.</li>
</ol>

<p>The deployment process can take up to 5 minutes. When the algorithm deploys, the <a href="/docs/v2/cloud-platform/live-trading/results">live results page</a> displays. If you know your brokerage positions before you deployed, you can verify they have been loaded properly by checking your equity value in the runtime statistics, your cashbook holdings, and your position holdings.</p>
