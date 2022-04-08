<?php 

session_start();
$str = "";
$exit_status = -1;
if(isset($_SESSION['changed']) && ($_SESSION['changed'] == true)){
	unset($_SESSION['changed']);
}

else{
	if(isset($_POST['compile'])){
		if(isset($_POST['problem'])){
			include_once('compilers/compiler_python.php');
		}
		unset($_POST['compile']);
	}
}

?>

<html>
<head>
	<title>OSD - Python Code Interview</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Include script and styles for the code editor and web page. -->
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="codemirror/lib/codemirror.css">
	<link rel="stylesheet" href="codemirror/addon/fold/foldgutter.css">
	<link rel="stylesheet" href="codemirror/addon/dialog/dialog.css">
	<link rel="stylesheet" href="codemirror/theme/monokai.css">
	<link rel="stylesheet" href="codemirror/theme/twilight.css">
	<link rel="stylesheet" href="css/main.css">

	<script src="codemirror/lib/codemirror.js"></script>
	<script src="codemirror/addon/selection/active-line.js"></script>
	<script src="codemirror/addon/search/searchcursor.js"></script>
	<script src="codemirror/addon/search/search.js"></script>
	<script src="codemirror/addon/dialog/dialog.js"></script>
	<script src="codemirror/addon/edit/matchbrackets.js"></script>
	<script src="codemirror/addon/edit/closebrackets.js"></script>
	<script src="codemirror/addon/comment/comment.js"></script>
	<script src="codemirror/addon/wrap/hardwrap.js"></script>
	<script src="codemirror/addon/fold/foldcode.js"></script>
	<script src="codemirror/addon/fold/brace-fold.js"></script>
	<script src="codemirror/mode/clike/clike.js"></script>
	<script src="codemirror/mode/python/python.js"></script>
	<script src="codemirror/mode/javascript/javascript.js"></script>
	<script src="codemirror/keymap/sublime.js"></script>
	

	<script type="text/javascript">		
		function changeProblem() {
		  var str = document.getElementById("problem").value;
		  var xhttp = new XMLHttpRequest();
		  xhttp.onreadystatechange = function() {
		    if (xhttp.readyState == 4 && xhttp.status == 200) {
		    	window.location.reload(true); 
		    }
		  };
		  xhttp.open("POST", "ajax/change_problem.php?q="+str, true);
		  xhttp.send();
		}
	</script>

</head>
<body class="bg-dark">
	<div class="container-fluid">

		<header>
			<div class="wellwell">
				<h2>OSD - Python Code Interview</h2>
			</div>
		</header>
		<div class="result">
		<?php
			// if compiled successfully, show output.
			if($exit_status == 0){ ?>
			<div class="panel panel-success">
				<div class="panel-heading">
					<h5>Output</h5>
				</div>
				<div class="panel-body">
					<?php echo $str; ?>
				</div>
			</div>
		<?php } ?>
		<?php
			// if there is any error, show error.
			if($exit_status == 1){ ?>
			<div class="panel panel-danger">
				<div class="panel-heading">
					<h5>Error</h5>
				</div>
				<div class="panel-body">
					<?php echo $str; ?>
				</div>
			</div>
		<?php } ?>
		</div>

		<div class="main-content">
			<form action="index.php" method="post" role="form">
			
				<div class="row">
					<div class="col-sm-9">
					<textarea rows="40" cols="170" name="program" class="program" id="code"><?php 
							if(isset($_SESSION['python_program'])){
								echo $_SESSION['python_program'];
							} else {
								echo "";
							}
						?></textarea>
					</div>
			

					<div class="col-sm-3 side-content">
						<div class="form-group">
							<select name="problem" onchange="changeProblem()" id="problem" class="form-control">
								<option value="e1p1" selected> Problem 1 </option>
								<option value="e1p2"> Problem 2 </option>
							</select>
						</div>

						<div class="form-group">
							<!-- Text box for standard  input. -->
							<h2>Input</h2>
							<textarea rows="5" cols="70" name="input" class="form-control"></textarea><br />
						</div>
						
						<div class="form-group">
							<input class="btn btn-primary" type="submit" value="Compile And Run" name="compile">
						</div>
					</div>
				</div>
			</form>
		</div>	
	</div>



	<script>
		// Script for the editor.
		var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
		    styleActiveLine: true,
		    lineNumbers: true,
		    lineWrapping: true,
		    mode: {
					name: 'text/x-cython',
					version: 3,
					singleLineStringErrors: false
				},
		    keyMap: "sublime",
		    autoCloseBrackets: true,
		    matchBrackets: true,
		    showCursorWhenSelecting: true,
		    theme: "twilight",
		    tabSize: 2
		  });
	</script>


</body>
</html>