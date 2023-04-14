<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Add New Data</h2>
                    </div>
                    <p>Please fill this form and submit to add student record to the database.</p>
                    <form action="updateNilaiDo.php" method="post">
                    <select name="nim" id="nim">
                        <option value="sv_001">joko</option>
                        <option value="sv_002">paul</option>
                        <option value="sv_003">andy</option>
                    </select>
                    

                    <br>
                    <select name="kode_mk" id="kode_mk">
                <?php
                $curl= curl_init();
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                //Pastikan sesuai dengan alamat endpoint dari REST API di UBUNTU, 
                curl_setopt($curl, CURLOPT_URL, 'http://localhost/API/uts_api.php');
                $res = curl_exec($curl);
                $json = json_decode($res, true);
                for ($i = 0; $i < 3; $i++){

                echo "<option value = '{$json["data"][$i]["kode_mk"]}'> {$json["data"][$i]["nama_mk"]} </option>";
                }
                
                ?>
                </select>
                        <div class="form-group">
                            <label>nilai</label>
                            <input type="text" name="nilai" class="form-control">
                        </div>

                        <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>