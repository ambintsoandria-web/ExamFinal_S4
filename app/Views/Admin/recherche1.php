<form method="GET" action="<?= site_url('admin/recherche') ?>">
    <p>
        <select name="departementId" onchange="this.form.submit()">
            <?php foreach ($departements as $d) { ?>
                <option value="<?= $d['id'] ?>" <?= ($selectedDept ?? '') == $d['id'] ? 'selected' : '' ?>>
                    <?= $d['nom'] ?>
                </option>
            <?php } ?>
        </select>
    </p>
    <p>
        <select name="empId">
            <option value="">Choisir un employé</option>
            <?php if (!empty($employes)): ?>
                <?php foreach ($employes as $emp) { ?>
                    <option value="<?= $emp['id'] ?>">
                        <?= $emp['nom'] . ' ' . $emp['prenom'] ?>
                    </option>
                <?php } ?>
            <?php endif; ?>
        </select>
    </p>
</form>

<!-- public function recherche()
{
    $data['departements'] = $this->departementModel->findAll();
    $data['employes'] = [];
    $data['selectedDept'] = null;

    $deptId = $this->request->getGet('departementId');
    
    if ($deptId) {
        $data['employes'] = $this->userModel->where('departement_id', $deptId)->findAll();
        $data['selectedDept'] = $deptId;
    }

    return view('Admin/recherche', $data);
} -->