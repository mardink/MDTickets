<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Martijn
 * Date: 14-8-13
 * Time: 19:45
 * To change this template use File | Settings | File Templates.
 */
defined('_JEXEC') or die();
// Load helper
$this->loadHelper('dashboard');
JHTML::_('behavior.framework');
// eerst JQuery toevoegen
JHtml::_('bootstrap.framework');

FOFTemplateUtils::addJS('media://com_mdtickets/js/mdtickets_dashboard.js');
// load JQPlot js files
FOFTemplateUtils::addJS('media://com_mdtickets/js/jqplot/jquery.jqplot.min.js');
FOFTemplateUtils::addJS('media://com_mdtickets/js/jqplot/jqplot.barRenderer.min.js');
FOFTemplateUtils::addJS('media://com_mdtickets/js/jqplot/jqplot.categoryAxisRenderer.min.js');
FOFTemplateUtils::addJS('media://com_mdtickets/js/jqplot/jqplot.pointLabels.min.js');
FOFTemplateUtils::addJS('media://com_mdtickets/js/jqplot/jqplot.pieRenderer.min.js');

// Load the CSS file
FOFTemplateUtils::addCSS('media://com_mdtickets/css/mdtickets.css');
FOFTemplateUtils::addCSS('media://com_mdtickets/css/jquery.jqplot.min.css');

//variables
$user = JFactory::getUser();
$username =  $user->get('username');
$user_id = $user->id;
$name_user = $user->name;

// set the return page after succesfull login
$return = "index.php?option=com_mdtickets&view=dashboard";
$return = urlencode(base64_encode($return));
$current_date = date("Y-m-d");
$warning_date = date("Y-m-d", strtotime("- 8 day"));

?>
<!-- begin login / logout form -->
<div class="row" xmlns="http://www.w3.org/1999/html">
        <?php if ($user_id != "0"){ ?>
            <div class="offset10">
        <?php echo JText::_( 'COM_MDTICKETS_WELCOME' );
        echo " " . $username;?>
        <a href="index.php?option=com_users&task=user.logout&<?php echo JSession::getFormToken(); ?>=1">
            <input  type="button" name="Submit" class="btn btn-primary" value="Logout">
        </a>
    </div>
    <?php } else {?>

            <form id="mylogin" class="pull-right" action="<?php echo JURI::root()?>index.php?option=com_users&task=user.login" method="POST">
                <input type="text" name="username" id="username" placeholder="username.." />
               <input type="password" name="password" id="password" placeholder="Password..." />
                <input type="hidden" name="return" value="<?php echo $return; ?>" />
                <?php echo JHtml::_('form.token');?>
               <input type="submit" id="btn_login" name="btn_login" class="btn btn-primary" value="Login" />
            </form>
        <?php } ?>


</div> <!-- End of the login/logout form -->
<!-- Begin content -->
<div id="mdtickets-dashboard" class="container">
    <div class="row-fluid span10">
        <div class="row">
        <div class="well span6">
            <h5><?php echo JText::_('COM_MDTICKETS_DASHBOARD_LATESTNEW');?></h5>
            <?php $latestitems = MdticketsHelperDashboard::getLatestNew(5);
            foreach ($latestitems as $latestitem){
                $id = $latestitem->mdtickets_item_id;
                $ticketID = sprintf("%04d", $id);
                $showLatestDate = date("d-m-y", strtotime($latestitem->created_on));
                ?>
                <a href="index.php?option=com_mdtickets&view=item&task=edit&id=<?php echo $latestitem->mdtickets_item_id;?>"><?php echo $ticketID; ?></a>
                <?php echo " - " . $latestitem->short;?><span class="pull-right"><?php echo $showLatestDate;?></span><br/>
            <?php }
            ?>
        </div>
        <div class="well span6">
            <h5><?php echo JText::_('COM_MDTICKETS_DASHBOARD_LATESTCHANGED');?></h5>
            <?php $latestitemschanged = MdticketsHelperDashboard::getLatestChanged(5);
            foreach ($latestitemschanged as $latestitemchanged){
                $id_changed = $latestitemchanged->mdtickets_item_id;
                $ticketID_changed = sprintf("%04d", $id_changed);
                $showLatestDateChanged = date("d-m-y", strtotime($latestitemchanged->modified_on));
                ?>
                <a href="index.php?option=com_mdtickets&view=item&task=edit&id=<?php echo $latestitemchanged->mdtickets_item_id;?>"><?php echo $ticketID_changed; ?></a>
                <?php echo " - " . $latestitemchanged->short;?><span class="pull-right"><?php echo $showLatestDateChanged;?></span><br/>
            <?php }
            ?>
        </div>
        </div>
        <div class="row">
        <div class="well span6">
            <h5><?php echo JText::_('COM_MDTICKETS_DASHBOARD_LATESTFINISHED');?></h5>
            <?php $finisheditems = MdticketsHelperDashboard::getLatestFinished(5);
            foreach ($finisheditems as $finisheditem){
                $id_finished = $finisheditem->mdtickets_item_id;
                $ticketID_finished = sprintf("%04d", $id_finished);
                $showfinishedDate = date("d-m-y", strtotime($finisheditem->completion_date));
                ?>
                <a href="index.php?option=com_mdtickets&view=item&task=edit&id=<?php echo $finisheditemnisheditem->mdtickets_item_id;?>"><?php echo $ticketID_finished; ?></a>
                <?php echo " - " . $finisheditem->short;?><span class="pull-right"><?php echo $showfinishedDate;?></span><br/>
            <?php }
            ?>
        </div>
        <div class="well span6">
            <h5><?php echo JText::_('COM_MDTICKETS_DASHBOARD_DEADLINES');?></h5>
            <?php $deadlines = MdticketsHelperDashboard::getDeadlines(5);
            foreach ($deadlines as $deadline){
                $id_deadline = $deadline->mdtickets_item_id;
                $ticketID_deadline = sprintf("%04d", $id_deadline);
                $showdeadlineDate = date("d-m-y", strtotime($deadline->deadline));
                ?>
                <a href="index.php?option=com_mdtickets&view=item&task=edit&id=<?php echo $deadline->mdtickets_item_id;?>"><?php echo $ticketID_deadline; ?></a>
                <?php echo " - " . $deadline->short;?><span class="pull-right <?php
                if($showdeadlineDate < $current_date) { echo "deadline_error";
                } elseif ($showdeadlineDate >= $warning_date) { echo "deadlinewarning";}?>"><?php echo $showdeadlineDate;?></span><br/>
            <?php }
            ?>
        </div>
        </div>

        <!-- Row for jQplot graphs -->
        <div class="row">
            <div class="span6">
                <div id="chart1" style="height:300px;width:600px; "></div>
            </div>
            <div class="span6">
                <div id="chart2" style="height:300px;width:600px; "></div>
            </div>
        </div>
    </div>
    <div class="well row span2">
        <!-- Begin load a joomla module position. Module posname Dashboard -->
        <?php jimport('joomla.application.module.helper');
        // this is where you want to load your module position
        $modules = JModuleHelper::getModules('dashboard');
        foreach($modules as $module)
        {
            echo JModuleHelper::renderModule($module);
        }
        ?>
        <!-- End load a joomla module position. Module posname Dashboard -->
    </div>
    <div class="well row span2">
        <h5><?php echo JText::_('COM_MDTICKETS_DASHBOARD_STATISTICS');?></h5>
        <a href="index.php?option=com_mdtickets&view=items&task=browse&finished=0"><?php echo JText::_('COM_MDTICKETS_DASHBOARD_OPENCALLS');?></a><span class="pull-right"><?php echo MdticketsHelperDashboard::getCallsOpen();?></span><br/>
        <a href="index.php?option=com_mdtickets&view=items&prio=Hoog&assigned="><?php echo JText::_('COM_MDTICKETS_DASHBOARD_PRIOHIGH');?></a><span class="pull-right"><?php echo MdticketsHelperDashboard::getCallsPrioHigh();?></span><br/>
        <a href="index.php?option=com_mdtickets&view=items&prio=Normaal&assigned="><?php echo JText::_('COM_MDTICKETS_DASHBOARD_PRIONORMAL');?></a><span class="pull-right"><?php echo MdticketsHelperDashboard::getCallsPrioNormal();?></span><br/>
        <a href="index.php?option=com_mdtickets&view=items&prio=Laag&assigned="><?php echo JText::_('COM_MDTICKETS_DASHBOARD_PRIOLOW');?></a><span class="pull-right"><?php echo MdticketsHelperDashboard::getCallsPrioLow();?></span><br/>
        <a href="index.php?option=com_mdtickets&view=items&prio=tzt&assigned="><?php echo JText::_('COM_MDTICKETS_DASHBOARD_PRIOTZT');?></a><span class="pull-right"><?php echo MdticketsHelperDashboard::getCallsPrioTzt();?></span><br/>
        <a href="index.php?option=com_mdtickets&view=items&prio=Periodiek&assigned="><?php echo JText::_('COM_MDTICKETS_DASHBOARD_PRIOPERIODIEK');?></a><span class="pull-right"><?php echo MdticketsHelperDashboard::getCallsPrioPeriodiek();?></span><br/>
        <a href="index.php?option=com_mdtickets&view=items&assigned=MHI&prio="><?php echo JText::_('COM_MDTICKETS_DASHBOARD_EIGEN');?></a><span class="pull-right"><?php echo MdticketsHelperDashboard::getCallsUser($name_user);?></span><br/>
        <a href="index.php?option=com_mdtickets&view=items&assigned=ITON&prio="><?php echo JText::_('COM_MDTICKETS_DASHBOARD_ITON');?></a><span class="pull-right"><?php echo MdticketsHelperDashboard::getCallsIton();?></span><br/>
    </div>


</div>
</div><!-- End content -->
<?php // prepare data for graphs
$charts2 = MdticketsHelperDashboard::getCallsCategorie();
$charts1 = MdticketsHelperDashboard::getCallsCountNew();
$charts1closed = MdticketsHelperDashboard::getCallsCountClosed();
$charts1iton = MdticketsHelperDashboard::getCallsCountIton();
?>
    <!-- Script chart1 -->
    <script>
        jQuery(document).ready(function(){
            var s1 = [<?php foreach($charts1 as $chart1){ echo $chart1->count . ', ';}?>]
            var s2 = [<?php foreach($charts1closed as $chart1closed){ echo $chart1closed->count . ', ';}?>];
            var s3 = [<?php foreach($charts1iton as $chart1iton){ echo $chart1iton->count . ', ';}?>];
            // Can specify a custom tick Array.
            // Ticks should match up one for each y value (category) in the series.
            var ticks = [<?php foreach($charts1 as $chart1){ echo '\'' .$chart1->month . '\', '; }?>];
            var plot1 = jQuery.jqplot('chart1', [s1, s2, s3], {
                // The "seriesDefaults" option is an options object that will
                // be applied to all series in the chart.
                seriesDefaults:{
                    renderer:jQuery.jqplot.BarRenderer,
                    rendererOptions: {fillToZero: true},
                    pointLabels: {show: true} // laat de waarde van de bar zien
                },
                // Custom labels for the series are specified with the "label"
                // option on the series option.  Here a series option object
                // is specified for each series.
                series:[
                    {label:'New Calls'},
                    {label:'closed calls'},
                    {label:'ITON Calls'}
                ],
                // Show the legend and put it outside the grid, but inside the
                // plot container, shrinking the grid to accomodate the legend.
                // A value of "outside" would not shrink the grid and allow
                // the legend to overflow the container.
                legend: {
                    show: true,
                    placement: 'outsideGrid'
                },
                axes: {
                    // Use a category axis on the x axis and use our custom ticks.
                    xaxis: {
                        renderer: jQuery.jqplot.CategoryAxisRenderer,
                        ticks: ticks
                    },
                    // Pad the y axis just a little so bars can get close to, but
                    // not touch, the grid boundaries.  1.2 is the default padding.
                    yaxis: {
                        pad: 1.05,

                        //tickOptions: {formatString: '$%d'}
                    }
                }

            });
        });
    </script>
<!-- Script chart2 -->
    <script>
        jQuery(document).ready(function(){
            var data = [
                <?php foreach($charts2 as $chart2){
                echo '[\''.$chart2->category .'\',' .$chart2->count . '], '; } ?>
            ];
            var plot1 = jQuery.jqplot ('chart2', [data],
                {
                    seriesDefaults: {
                        // Make this a pie chart.
                        renderer: jQuery.jqplot.PieRenderer,
                        rendererOptions: {
                            // Put data labels on the pie slices.
                            // By default, labels show the percentage of the slice.
                            showDataLabels: true
                        }
                    },
                    legend: { show:true, location: 'e' }
                }
            );
        });
    </script>
