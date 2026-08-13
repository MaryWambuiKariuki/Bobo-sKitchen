<?php

echo "Employee: " . password_hash("employee123", PASSWORD_DEFAULT) . "<br>";
echo "Employer: " . password_hash("employer123", PASSWORD_DEFAULT) . "<br>";
echo "Admin: " . password_hash("admin123", PASSWORD_DEFAULT);

?>