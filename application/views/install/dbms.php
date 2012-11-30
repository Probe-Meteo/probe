<div class="navbar navbar-inverse navbar-fixed-top">
	<ul class="breadcrumb">
	    <li class="active"><a href="/install/dbms"><?=i18n("install.breadcrumb.dbms")?></a> <span class="divider">/</span></li>
	    <li class="disabled"><?=i18n("install.breadcrumb.administrator")?> <span class="divider">/</span></li>
	    <li class="disabled"><?=i18n("install.breadcrumb.dashboard")?> <span class="divider">/</span></li>
	</ul>
</div>

<?=form_open('install/setupDbms', array(
		'id' => 'dbms',
		'class' => 'modal setup form-horizontal'
	)
);
?>

	<div class="modal-header">
		<!-- <legend> -->
			<h3><?=i18n("install.dbms.legend")?></h3>
		<!-- </legend>	 -->
	</div>
	<fieldset class="modal-body">
		<?=validation_errors()?>

		<!-- Server host/IP -->
		<div class="control-group">
			<label class="control-label" for="dbms-host">
				<?=sprintf('%s <span class="hidden">(%s)</span>%s', i18n('install.dbms.host'), i18n('required'), i18n('&nbsp;:')) ?>
			</label>
			<div class="controls">
				<input id="dbms-host"
					type="text" required
					name="dbms-host" value="<?=$dbmsHost?>" 
					class="input-large" placeholder="<?=i18n('install.dbms.host.placeholder')?>"
				>
			</div>
		</div>

		<!-- Server port (range between: 1-65535) -->
		<div class="control-group">
			<label class="control-label" for="dbms-port">
				<?=sprintf('%s <span class="hidden">(%s)</span>%s', i18n('install.dbms.port'), i18n('required'), i18n('&nbsp;:')) ?>
			</label>
			<div class="controls">
				<input id="dbms-port"
					type="number" min="1" max="65535" 
					name="dbms-port" value="<?=$dbmsPort?>" 
					class="input-mini" placeholder="<?=i18n('install.dbms.port.placeholder')?>"
				>
			</div>
		</div>

		<!-- Engine: MySQL vs. SQLite  -->
		<div class="control-group">
			<label class="control-label">
				<?=sprintf('%s <span class="hidden">(%s)</span>%s', i18n('install.dbms.engine'), i18n('required'), i18n('&nbsp;:')) ?>
			</label>
			<div class="controls">
				<label class="control-label inline" for="dbms-engine-mysql">
					<input id="dbms-engine-mysql"
 						type="radio" checked 
						name="dbms-engine" value="mysql"
					>
					<?=sprintf('%s <span class="hidden">(%s)</span>', i18n('install.dbms.engine-mysql'), i18n('required')) ?>
				</label>
				<label class="control-label inline" for="dbms-engine-sqlite">
					<input id="dbms-engine-sqlite"
						type="radio" 
						name="dbms-engine" value="sqlite"
					>
					<?=sprintf('%s <span class="hidden">(%s)</span>', i18n('install.dbms.engine-sqlite'), i18n('required')) ?>
				</label>
			</div>
		</div>


		<!-- Existing database vs. new one -->
	<!-- 	<div class="control-group">
			<label class="control-label">
				<?=sprintf('%s <span class="hidden">(%s)</span>%s', i18n('install.dbms.database.selection'), i18n('required'), i18n('&nbsp;:')) ?>
			</label>
			<div class="controls">
				<label class="control-label inline" for="dbms-database-reuse">
					<input type="radio" name="dbms-database-selection" id="dbms-database-reuse" value="<?=$dbmsPort?>" checked class="input-mini" >
					<?=sprintf('%s <span class="hidden">(%s)</span>', i18n('install.dbms.database-reuse'), i18n('required')) ?>
				</label>
				<label class="control-label inline" for="dbms-database-create">
					<input type="radio" name="dbms-database-selection" id="dbms-database-create" value="<?=$dbmsPort?>" class="input-mini" >
					<?=sprintf('%s <span class="hidden">(%s)</span>', i18n('install.dbms.database-create'), i18n('required')) ?>
				</label>
			</div>
		</div> -->

		<div class="control-group">
		<!-- Server database name -->
			<label class="control-label" for="dbms-database-name">
				<?=sprintf('%s %s', i18n('install.dbms.database-name'), i18n('&nbsp;:'))?>
			</label>
			<div class="controls">
				<input id="dbms-database-name"
					type="text" disabled
					name="dbms-database-name" value="<?=$dbmsDatabaseName?>"
					class="input-large" 
				>
			    <!-- <span class="input-large uneditable-input"><?=$dbmsDatabaseName?></span> -->
				<!-- <input type="hidden" id="dbms-database-name" value="<?=$dbmsDatabaseName?>" class="input-large" > -->
			</div>
		</div>

    <div class="alert">
    	<?=i18n('install.dbms.advanced-user.management')?>
    </div>

		<!-- Database's manager's username -->
		<div class="control-group">		
			<label class="control-label" for="dbms-username">
				<?=sprintf('%s <span class="hidden">(%s)</span>%s', i18n('install.dbms.username'), i18n('required'), i18n('&nbsp;:'))?>
			</label>
			<div class="controls">
				<input id="dbms-username"
					type="text" required
					name="dbms-username" value="<?=$dbmsUsername?>" 
					class="input-large" placeholder="<?=i18n('install.dbms.username.placeholder')?>"
				>
			</div>
		</div>

		<!-- Database's manager's password -->
		<div class="control-group">		
			<label class="control-label" for="dbms-password">
				<?=sprintf('%s <span class="hidden">(%s)</span>%s', i18n('install.dbms.password'), i18n('required'), i18n('&nbsp;:'))?>
			</label>
			<div class="controls">
				<input id="dbms-password"
					type="password" required
					name="dbms-password" value="<?=$dbmsPassword?>"
					class="input-large" placeholder="<?=i18n('install.dbms.password.placeholder')?>"
				>
			</div>
		</div>

	</fieldset>
	<div class="modal-footer">
		<?=form_submit('configure', i18n('install.dbms.configure'), 'class="btn btn-primary pull-right"')?>
	</div>
<?=form_close()?>
<?
// <p>
// Problème de connexion localhost vs. any host :
// 1. accès depuis le serveur à un utilisateur sur @'%'. Il faut supprimer les utilisateur anonyme (cf. ci-dessus). sur @'localhost' pas de soucis.
// 2. accès depuis un serveur distant à @'%', il faut changer dans /etc/mysql/my.cnf la valeur de bind-address. Connexion vers @'localhost' ok
// </p>
?>