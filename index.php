<?php
// Define the age bands for the MATCH functionality
$age_bands = [25, 30, 35, 40, 45, 50, 55, 60];  // Age ranges to match

// Define the corresponding premiums for each age band (as rows)
$premium_data = [
    [3520, 4309, 5193, 6188, 6947, 7757, 8623, 9552, 10550],  // Premiums for age band 25-29
    [3655, 4520, 5509, 6648, 7487, 8392, 9371, 10431, 11583],  // Premiums for age band 30-34
    [4006, 5056, 6296, 7768, 8801, 9930, 11167, 12525, 14020],  // Premiums for age band 35-39
    [4673, 6067, 7761, 9839, 11235, 12776, 14484, 16379, 18487],  // Premiums for age band 40-44
    [5685, 7595, 9988, 13018, 14969, 17144, 19576, 22301, 25360],  // Premiums for age band 45-49
    [7282, 9999, 13490, 18030, 20859, 24032, 27602, 31627, 36177],  // Premiums for age band 50-54
    [9612, 13500, 18624, 25464, 29586, 34238, 39503, 45477, 52269],  // Premiums for age band 55-59
    [16091, 23222, 32326, 44234, 51805, 60201, 69553, 80015, 91765],  // Premiums for age band 60+
];

// Function to get premiums based on age
function get_premiums_for_age($age, $age_bands, $premium_data) {
    $row_index = null;

    // Find the row index where the age falls within the age_bands
    for ($i = 0; $i < count($age_bands) - 1; $i++) {
        if ($age_bands[$i] <= $age && $age < $age_bands[$i + 1]) {
            $row_index = $i;
            break;
        }
    }

    // Handle age greater than the last band (60+)
    if ($row_index === null && $age >= end($age_bands)) {
        $row_index = count($age_bands) - 1;
    }

    if ($row_index !== null) {
        // Return the corresponding premiums for the age band
        return $premium_data[$row_index];
    } else {
        return null;  // Return null if age doesn't fall into any range
    }
}

// Handle the form submission
$premiums = null;
$age = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['age']) && is_numeric($_POST['age'])) {
        $age = intval($_POST['age']);
        $premiums = get_premiums_for_age($age, $age_bands, $premium_data);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Lookup</title>
    <style>
        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        h1, h2 {
            color: #333;
            font-weight: 100;
            font-size: 18px; /* Heading font size */
        }

        /* Form Styling */
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            width: 100%;
            max-width: 500px;
        }

        input[type="number"] {
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        button {
            padding: 10px;
            font-size: 16px;
            color: white;
            background-color: #007BFF;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Table Styling */
        table {
            width: 100%;
            max-width: 800px;
            margin-top: 20px;
            border-collapse: collapse;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 8px;
            text-align: center;
            border-bottom: 1px solid #ddd;
            font-size: 12px;
            white-space: nowrap;
        }

        th {
            background-color: #007BFF;
            color: white;
            font-size: 14px;
        }

        td {
            background-color: #f9f9f9;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Responsive Styles */
        @media (min-width: 320px) and (max-width: 480px){
            form {
                width: 100%;
                padding: 10px;
            }

            input[type="number"], button {
                width: 100%;
            }

            table {
                width: 100%;
            }

            th, td {
                font-size: 10px;
                padding: 6px;
            }
        }
    </style>
</head>
<body>

    <h1>Enter Your Age</h1>

    <form method="POST">
        <input type="number" name="age" placeholder="Enter age" required>
        <button type="submit">Get Premiums</button>
    </form>

    <?php if ($premiums !== null): ?>
    <h2>Premiums for Your Age Band:</h2>
    <table>
        <thead>
            <tr>
                <th>Age</th>
                <th>Premium 1</th>
                <th>Premium 2</th>
                <th>Premium 3</th>
                <th>Premium 4</th>
                <th>Premium 5</th>
                <th>Premium 6</th>
                <th>Premium 7</th>
                <th>Premium 8</th>
                <th>Premium 9</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo htmlspecialchars($age); ?></td>
                <?php foreach ($premiums as $premium): ?>
                    <td style="background-color: orange; font-weight: bold;"><?php echo number_format($premium); ?></td>
                <?php endforeach; ?>
            </tr>
        </tbody>
    </table> 

    <img src="img\sumInsured.png" alt="Descriptive Text for Image" style="max-width: 100%; height: auto; margin-top: 20px;">
    <?php endif; ?>

    <!-- Benefits and Sum Insured Table -->
    <h2>Benefit and Sum Insured</h2>
    <table>
        <thead>
            <tr>
                <th>Benefit</th>
                <th>Sum Ins 1</th>
                <th>Sum Ins 2</th>
                <th>Sum Ins 3</th>
                <th>Sum Ins 4</th>
                <th>Sum Ins 5</th>
                <th>Sum Ins 6</th>
                <th>Sum Ins 7</th>
                <th>Sum Ins 8</th>
                <th>Sum Ins 9</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>SUM ASSURED</td>
                <td>2,000,000</td>
                <td>3,000,000</td>
                <td>4,000,000</td>
                <td>5,000,000</td>
                <td>6,000,000</td>
                <td>7,000,000</td>
                <td>8,000,000</td>
                <td>9,000,000</td>
                <td>10,000,000</td>
            </tr>
            <tr>
                <td>NATURAL DEATH</td>
                <td>2,000,000</td>
                <td>3,000,000</td>
                <td>4,000,000</td>
                <td>5,000,000</td>
                <td>6,000,000</td>
                <td>7,000,000</td>
                <td>8,000,000</td>
                <td>9,000,000</td>
                <td>10,000,000</td>
            </tr>
            <tr>
                <td>SEVERE DISMEMBERMENT</td>
                <td>4,000,000</td>
                <td>6,000,000</td>
                <td>8,000,000</td>
                <td>10,000,000</td>
                <td>12,000,000</td>
                <td>14,000,000</td>
                <td>16,000,000</td>
                <td>18,000,000</td>
                <td>20,000,000</td>
            </tr>
            <tr>
                <td>PERMANENT DISABILITY</td>
                <td>4,000,000</td>
                <td>6,000,000</td>
                <td>8,000,000</td>
                <td>10,000,000</td>
                <td>12,000,000</td>
                <td>14,000,000</td>
                <td>16,000,000</td>
                <td>18,000,000</td>
                <td>20,000,000</td>
            </tr>
            <tr>
                <td>CRITICAL ILLNESS</td>
                <td>1,000,000</td>
                <td>1,500,000</td>
                <td>2,000,000</td>
                <td>2,500,000</td>
                <td>3,000,000</td>
                <td>3,500,000</td>
                <td>4,000,000</td>
                <td>4,500,000</td>
                <td>5,000,000</td>
            </tr>
            <tr>
                <td>ACCIDENTAL DEATH</td>
                <td>4,000,000</td>
                <td>6,000,000</td>
                <td>8,000,000</td>
                <td>10,000,000</td>
                <td>12,000,000</td>
                <td>14,000,000</td>
                <td>16,000,000</td>
                <td>18,000,000</td>
                <td>20,000,000</td>
            </tr>
        </tbody>
    </table>

</body>
</html>
