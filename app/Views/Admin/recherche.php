<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Page de recherche</h1>
    <p>
        <select name="departementId" id="departementId">
            <?php foreach ($departements as $d) { ?>
                <option value="<?= $d['id'] ?>"><?= $d['nom'] ?></option>
            <?php } ?>
        </select>
    </p>
    <p>
        <select name="empId" id="empSelect">
            <option value="">Choisir un employé</option>
        </select>
    </p>
    <p>
        <select name="congeId" id="congeSelect">
            <option value="">Choisir un conge</option>
        </select>
    </p>
    <script type="text/javascript">
        document.getElementById('departementId').addEventListener('change', function () {
            var deptId = this.value;
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "<?= site_url('admin/getEmpByDept') ?>?deptId=" + deptId, true);

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var employes = JSON.parse(xhr.responseText);
                    var empSelect = document.getElementById('empSelect');
                    empSelect.innerHTML = '<option value="">Choisir un employé</option>';
                    for (var i = 0; i < employes.length; i++) {
                        var option = document.createElement('option');
                        option.value = employes[i].id;
                        option.text = employes[i].nom + ' ' + employes[i].prenom;
                        empSelect.appendChild(option);
                    }
                }
            };
            xhr.send();
        });
    </script>
    <script type="text/javascript">
        document.getElementById('empSelect').addEventListener('change', function () {
            var empId = this.value;
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '<?= site_url('admin/getCongeByEmp') ?>?empId=' + empId, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var conge = JSON.parse(xhr.responseText);
                    var congeSelect = document.getElementById('congeSelect');
                    congeSelect.innerHTML = '<option value="">Choisir un conge</option>';
                    for (let i = 0; i < conge.length; i++) {
                        var option = document.createElement('option');
                        option.value = conge[i].id;
                        option.text = conge[i].id + ' ' + conge[i].motif;
                        congeSelect.appendChild(option);
                    }
                }
            }
            xhr.send();
        });
    </script>
</body>

</html>