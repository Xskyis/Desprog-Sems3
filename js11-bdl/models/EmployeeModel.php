<?php

/**
 * FILE: models/EmployeeModel.php
 * FUNGSI: Berisi semua operasi database untuk tabel employees
 */
class EmployeeModel
{
    private $conn;
    private $table_name = "employees";

    // Constructor
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // METHOD 1: Read semua employees
    public function getAllEmployees()
    {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // METHOD 2: Create employee baru
    public function createEmployee($data)
    {
        $query = "INSERT INTO " . $this->table_name . " (first_name, last_name, 
        email, department, position, salary, hire_date) VALUES (:first_name, :last_name, 
        :email, :department, :position, :salary, :hire_date)";
        $stmt = $this->conn->prepare($query);

        // Bind parameters untuk keamanan (mencegah SQL injection)
        $stmt->bindParam(":first_name", $data['first_name']);
        $stmt->bindParam(":last_name", $data['last_name']);
        $stmt->bindParam(":email", $data['email']);
        $stmt->bindParam(":department", $data['department']);
        $stmt->bindParam(":position", $data['position']);
        $stmt->bindParam(":salary", $data['salary']);
        $stmt->bindParam(":hire_date", $data['hire_date']);

        return $stmt->execute();
    }

    // METHOD 3: Update employee
    public function updateEmployee($id, $data)
    {
        // Validate and format salary to fit DECIMAL(10,2):
        // - must be numeric
        // - absolute value must be less than 10^8 (DECIMAL(10,2) constraint)
        if (!isset($data['salary']) || !is_numeric($data['salary'])) {
            return false;
        }
        $salary = round((float)$data['salary'], 2);
        if (abs($salary) >= 100000000) {
            // salary out of range for DECIMAL(10,2)
            return false;
        }
        // format salary as string with 2 decimal places for binding
        $salary_str = number_format($salary, 2, '.', '');

        $query = "UPDATE " . $this->table_name . "
        SET first_name = :first_name, last_name = :last_name, 
        email = :email, department = :department, 
        position = :position, salary = :salary, hire_date = :hire_date
        WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // ensure id is integer
        $id = (int)$id;

        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":first_name", $data['first_name']);
        $stmt->bindParam(":last_name", $data['last_name']);
        $stmt->bindParam(":email", $data['email']);
        $stmt->bindParam(":department", $data['department']);
        $stmt->bindParam(":position", $data['position']);
        // bind formatted salary string (bindParam uses reference)
        $stmt->bindParam(":salary", $salary_str);
        $stmt->bindParam(":hire_date", $data['hire_date']);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            // execution failed (e.g. constraint); return false
            return false;
        }
    }

    // METHOD 4: Delete employee
    public function deleteEmployee($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    // METHOD 5: Get single employee by ID
    public function getEmployeeById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // METHOD 6: Get data dari VIEW employee_summary
    public function getEmployeeSummary()
    {
        $query = "SELECT * FROM employee_summary";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // METHOD 7: Get data dari view department_stats
    public function getDepartmentStats()
    {
        $query = "SELECT * FROM department_stats";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // METHOD 8: Get data dari MATERIALIZED VIEW dashboard_summary
    public function getDashboardSummary()
    {
        $query = "SELECT * FROM dashboard_summary";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // METHOD 9: Refresh materialized view
    public function refreshDashboard()
    {
        $query = "REFRESH MATERIALIZED VIEW dashboard_summary";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute();
    }

    // METHOD 10: Menampilkan Rata-rata gaji, gaji tertinggi, gaji terendah per departemen
    public function getSalaryStatsByDepartment()
    {
        $query = "SELECT department,
                         AVG(salary) AS avg_salary,
                         MAX(salary) AS max_salary,
                         MIN(salary) AS min_salary
                  FROM " . $this->table_name . "
                  GROUP BY department
                  ORDER BY department";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // METHOD 11: Get employee overview statistics
    public function getEmployeeOverview()
    {
        $query = "SELECT 
                         COUNT(*) AS total_employees,
                         SUM(salary) AS total_salary,
                         AVG(EXTRACT(YEAR FROM AGE(hire_date))) AS avg_tenure_years
                  FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // METHOD 12: Get tenure statistics
    public function getTenureStats()
    {
        $query = "SELECT 
                         CASE 
                             WHEN EXTRACT(YEAR FROM AGE(hire_date)) < 1 THEN 'Junior'
                             WHEN EXTRACT(YEAR FROM AGE(hire_date)) BETWEEN 1 AND 3 THEN 'Middle'
                             ELSE 'Senior'
                         END AS tenure_group,
                         COUNT(*) AS total_karyawan
                  FROM " . $this->table_name . "
                  GROUP BY tenure_group
                  ORDER BY tenure_group";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
