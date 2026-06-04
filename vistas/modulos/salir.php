<?php

session_destroy();

echo '<script>

	localStorage.removeItem("rango");
	window.location = "inicio";

</script>';