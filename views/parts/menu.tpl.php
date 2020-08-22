<nav class="navbar sticky-top navbar-dark bg-mongodb">

    <a class="navbar-brand" href="<?php echo MPG_BASE_URL; ?>/index"><?php echo MPG_APP_NAME; ?></a>

    <div class="navbar-nav">
        <a class="nav-item nav-link<?php echo ('collection' === $viewName) ? ' active' : ''; ?>" href="<?php echo MPG_BASE_URL; ?>/manageCollections">Manage collections</a>
        <a class="nav-item nav-link<?php echo ('collection.import' === $viewName) ? ' active' : ''; ?>" href="<?php echo MPG_BASE_URL; ?>/importDocuments">Import documents</a>
        <a class="nav-item nav-link<?php echo ('database.visualize' === $viewName) ? ' active' : ''; ?>" href="<?php echo MPG_BASE_URL; ?>/visualizeDatabase">Visualize database</a>
        <a class="nav-item nav-link<?php echo ('database.query' === $viewName) ? ' active' : ''; ?>" href="<?php echo MPG_BASE_URL; ?>/queryDatabase">Query database</a>
        <a class="nav-item nav-link<?php echo ('collection.indexes' === $viewName) ? ' active' : ''; ?>" href="<?php echo MPG_BASE_URL; ?>/manageIndexes">Manage indexes</a>
        <a class="nav-item nav-link<?php echo ('database.users' === $viewName) ? ' active' : ''; ?>" href="<?php echo MPG_BASE_URL; ?>/manageUsers">Manage users</a>
        <a class="nav-item nav-link" href="<?php echo MPG_BASE_URL; ?>/logout">Logout</a>
    </div>

    <button id="menu-toggle-button"><i class="fa fa-bars" aria-hidden="true"></i></button>

</nav>