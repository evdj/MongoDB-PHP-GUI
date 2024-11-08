<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>MongoDB PHP GUI v<?php echo MPG\VERSION; ?></title>

    <link rel="icon" href="./assets/images/mpg-icon.svg">
    <link rel="mask-icon" href="./assets/images/mpg-safari-icon.svg" color="#6eb825">
    <link rel="apple-touch-icon" href="./assets/images/mpg-ios-icon.png">

    <link rel="stylesheet" href="./assets/css/ubuntu-font.css">
    <link rel="stylesheet" href="./assets/css/fontawesome-custom.css">
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/jsonview.bundle.css">
    <link rel="stylesheet" href="./source/css/inner.css">
    <link rel="stylesheet" href="./source/css/caret.css">

    <script src="./source/js/_base.js"></script>
    <script src="./source/js/jsonViewModified.js"></script>

</head>

<body onLoad="setSystemStatus(); setRepliStatus(); setServerStatus();">

    <?php require MPG\ABS_PATH . '/views/parts/menu.view.php'; ?>

    <div class="container-fluid">

        <div class="row">

            <div class="col-md-9">

                <div class="row">

                    <div class="col-md-12">
                    
                        <h2 class="d-inline-block">Server Info</h2>

                        <div>
                            <code id="mpg-output-code"></code>
                        </div>
                    
                        <h2 class="d-inline-block">Server status</h2>

                        <div>
                            <code id="mpg-output-code2"></code>
                        </div>

                        <h2 class="d-inline-block">Replication status</h2>

                        <div>
                            <code id="mpg-output-code3"></code>
                        </div>


                    </div>

                </div>
                
            </div>
            
        </div>
        
    </div>

    <?php
        $base = $systemStatus["info"];
        $newOutput = [];

        if (!empty($base)) {
            $major = [ 'hosts', 'setName', 'isWritablePrimary', 'secondary', 'primary', 'me', 'ok' ];
            foreach($major as $field) {
                $newOutput[$field] = $base[$field];
            }
        }

        $repl = $systemStatus["cmd"];
        $ba = null;
        if (!empty($repl)) {
            $major = [ 'set', 'myState', 'ok' ];
            $members_major = [ '_id', 'name', 'health', 'stateStr', 'syncSourceHost' ];
            foreach($repl as $base) {
                $arrayBase = (array)$base;
                foreach($major as $field) { $ba[$field] = $arrayBase[$field]; }
                foreach($arrayBase['members'] as $idx => $member) {
                    $arrayMember = (array)$member;
                    foreach($members_major as $field) { $ba['members'][$idx][$field] = $arrayMember[$field]; }
                }
            }
        }

        $repl = $systemStatus["ss"];
        $ss = null;
        if (!empty($repl)) {
            $major = [ 'network', 'opcounters', 'repl' ];
            foreach($repl as $base) {
                $arrayBase = (array)$base;
                foreach($major as $field) { $ss[$field] = $arrayBase[$field]; }
            }
        }
    ?>

    <script>
       var systemStatus = '<?= json_encode($newOutput) ?>';
       function setSystemStatus() {
           console.log('check 1');
           var outputCode = document.querySelector('#mpg-output-code');
           outputCode.innerHTML = '';

           var jsonViewTree = JsonView.createTree(systemStatus);
           JsonView.render(jsonViewTree, outputCode);
           JsonView.expandChildren(jsonViewTree);
       }

       var serverStatus = '<?= json_encode($ss) ?>';
       function setServerStatus() {
           console.log('check 2');
           var outputCode = document.querySelector('#mpg-output-code2');
           outputCode.innerHTML = '';

           var jsonViewTree = JsonView.createTree(serverStatus);
           JsonView.render(jsonViewTree, outputCode);
           JsonView.expandChildren(jsonViewTree);
       }

       var repliStatus = '<?= json_encode($ba) ?>';
       function setRepliStatus() {
           console.log('check 3');
           var outputCode = document.querySelector('#mpg-output-code3');
           outputCode.innerHTML = '';

           var jsonViewTree = JsonView.createTree(repliStatus);
           JsonView.render(jsonViewTree, outputCode);
           JsonView.expandChildren(jsonViewTree);
       }
    </script>

</body>

</html>
