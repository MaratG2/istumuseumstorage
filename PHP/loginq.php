<?php

header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Accept, X-Access-Token, X-Application-Name, X-Request-Sent-Time');

	if(isset($_POST["email"])
	{
		$email = $_POST["email"];
		
		//Connect to DB
		require dirname(__FILE__) . '/database.php';
		
		if ($stmt = $db->prepare("SELECT count(*) from public.users WHERE email = '?'"))
		{
			$stmt->bind_param('s', $email);
			
			if($stmt->execute())
			{
				$stmt->store_result();
				
				if($stmt->num_rows > 0)
				{
					/* bind result variables */
					$stmt->bind_result($loginq);

					/* fetch value */
					$stmt->fetch();
				}
				else
				{
					$errors[] = "Wrong email.";
				}
				$stmt->close();
			}
			else
			{
				$errors[] = "Something went wrong in exec, please try again.";
			}
		}
		else
		{
			$errors[] = "Something went wrong in prep, please try again.";
		}
		
		if(count($errors) > 0)
		{
			echo $errors[0];
		}
	}
	else
	{
		echo "Missing data.";
	}
?>