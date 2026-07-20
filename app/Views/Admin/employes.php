<?= view('partials/head', ['title' => 'TechMada RH']) ?>
<?php $formErrors = session()->getFlashdata('errors') ?? []; ?>
<section id="page-admin-employes" style="margin-top:3rem">
  <div class="app-wrap">

    <?= view('partials/sidebar', ['activeMenu' => $activeMenu ?? 'dashboard']) ?>

    <div class="main">
      <div class="topbar">
        <div>
          <div class="topbar-title">Gestion des employés</div>
          <div class="topbar-breadcrumb"><a href="/admin">Admin</a> <i class="bi bi-chevron-right"
              style="font-size:.6rem"></i> Employés</div>
        </div>
        <div class="topbar-actions">
          <a href="#" class="btn-forest" style="padding:7px 14px;font-size:.82rem"><i class="bi bi-person-plus"></i>
            Ajouter</a>
        </div>
      </div>

      <div class="content">

        <?php if (session()->getFlashdata('success')): ?>
          <div class="flash flash-success"><i
              class="bi bi-check-circle-fill"></i><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('erreur')): ?>
          <div class="flash flash-error"><i
              class="bi bi-exclamation-circle-fill"></i><?= esc(session()->getFlashdata('erreur')) ?></div>
        <?php endif; ?>
        <?php if ($formErrors): ?>
          <div class="flash flash-error">
            <i class="bi bi-exclamation-circle-fill"></i>
            <span><?= esc(implode(' ', $formErrors)) ?></span>
          </div>
        <?php endif; ?>

        <!-- Formulaire ajout -->
        <form action="<?= site_url('admin/employes/addEmp') ?>" method="post">
          <?= csrf_field() ?>
          <div class="form-section">
            <h3><i class="bi bi-person-plus" style="color:var(--forest);margin-right:6px"></i>Ajouter un employé</h3>
            <div class="form-grid-2" style="margin-bottom:1rem">
              <div class="f-group">
                <label class="f-label">Prénom</label>
                <input type="text" class="f-input" placeholder="Jean" name="prenom" required />
              </div>
              <div class="f-group">
                <label class="f-label">Nom</label>
                <input type="text" class="f-input" placeholder="Rakoto" name="nom" required />
              </div>
              <div class="f-group">
                <label class="f-label">Email</label>
                <input type="email" class="f-input" placeholder="jean.rakoto@techmada.mg" name="email" required />
              </div>
              <div class="f-group">
                <label class="f-label">Mot de passe initial</label>
                <input type="password" class="f-input" placeholder="À communiquer à l'employé" name="password"
                  required />
              </div>
              <div class="f-group">
                <label class="f-label">Département</label>
                <select class="f-select" name="departementId">
                  <?php foreach ($listeDepartement as $departement) {
                    ?>
                    <option value="<?= esc($departement['id']) ?>"><?= esc($departement['nom']) ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="f-group">
                <label class="f-label">Rôle</label>
                <select class="f-select" name="roleId">
                  <?php foreach ($roles as $r) { ?>
                    <option value="<?= esc($r['role']) ?>"><?= esc($r['role']) ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="f-group">
                <label class="f-label">Date d'embauche</label>
                <input type="date" class="f-input" name="dateEmbauche" required />
              </div>
            </div>
            <div class="flash flash-info" style="margin-bottom:1rem">
              <i class="bi bi-info-circle-fill"></i>
              <span style="font-size:.82rem">Les soldes de congés seront initialisés automatiquement selon les types de
                congé configurés.</span>
            </div>
            <div class="form-actions">
              <button class="btn-forest" type="submit"><i class="bi bi-plus"></i> Créer l'employé</button>
              <button class="btn-secondary" type="reset">Réinitialiser</button>
            </div>
          </div>
        </form>


        <!-- Liste employés -->
        <div class="data-card">
          <div class="data-card-head">
            <h3>Tous les employés</h3>
            <div style="display:flex;gap:6px">
              <input type="text" id="searchInput" class="f-input" placeholder="Rechercher..."
                style="width:200px;padding:6px 10px;font-size:.8rem" />
              <select id="deptFilter" class="f-select" style="font-size:.8rem;padding:6px 10px;width:auto">
                <option value="">Tous les depts</option>
                <?php foreach ($listeDepartement as $departement) { ?>
                  <option value="<?= $departement['id'] ?>"><?= $departement['nom'] ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <table class="tbl">
            <thead>
              <tr>
                <th>Employé</th>
                <th>Département</th>
                <th>Rôle</th>
                <th>Embauche</th>
                <th>Statut</th>
                <th>Solde annuel</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="employeesBody">
              <?php foreach ($listeEmp as $emp) { ?>
                <tr id="row_<?= $emp['id'] ?>" style="<?= $emp['actif'] == 0 ? 'opacity:.5' : '' ?>">
                  <td>
                    <div class="profile-row">
                      <div class="avatar av-green" style="width:32px;height:32px;font-size:.68rem">
                        <?= strtoupper(substr($emp['prenom'] ?? '', 0, 1) . substr($emp['nom'] ?? '', 0, 1)) ?>
                      </div>
                      <div class="profile-info">
                        <div class="pname"><?= esc($emp['prenom'] ?? '') ?>   <?= esc($emp['nom'] ?? '') ?></div>
                        <div class="pdept"><?= esc($emp['email'] ?? '') ?></div>
                      </div>
                    </div>
                  </td>
                  <td class="td-muted"><?= esc($emp['departName'] ?? '') ?></td>
                  <td><span class="type-badge"
                      style="background:#f1efe8;color:#444441"><?= esc($emp['role'] ?? 'employe') ?></span></td>
                  <td class="td-muted td-mono" style="font-size:.78rem"><?= esc($emp['date_embauche'] ?? '') ?></td>
                  <td><span class="statut s-approuvee"
                      style="font-size:.68rem"><?= $emp['actif'] == 1 ? 'actif' : 'inactif' ?></span></td>
                  <td><span
                      style="font-family:'DM Mono',monospace;font-size:.82rem;color:var(--forest)"><?= $emp['soldeAnnuelUtilise'] ?? 0 ?>
                      / <?= $emp['soldeAnnuelTolal'] ?? 0 ?></span></td>
                  <td>
                    <div class="action-btns">
                      <button class="btn-sm btn-edit"><i class="bi bi-pencil"></i> Éditer</button>
                      <button type="button" class="btn-sm btn-del" onclick="supprimer(<?= $emp['id'] ?>)">
                        <i class="bi bi-slash-circle"></i> Supprimer
                      </button>
                    </div>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>

      </div>
      <div class="footer-app"><i class="bi bi-c-circle"></i> 2025 <span>TechMada RH</span></div>
    </div>

  </div>
</section>

<script type="text/javascript">
  function supprimer(id) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "<?= site_url('admin/employes/deleteEmp') ?>", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
        if (xhr.responseText == "success") {
          document.getElementById("row_" + id).remove();
        }
      }
    };

    xhr.send("id=" + id + "&<?= csrf_token() ?>=<?= csrf_hash() ?>");
  }
</script>
<script type="text/javascript">
  document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const deptFilter = document.getElementById("deptFilter");
    const employeesBody = document.getElementById("employeesBody");

    function filterEmployees() {
      const search = searchInput.value;
      const departement = deptFilter.value;

      const url = "<?= site_url('admin/employes/filter') ?>?search=" + encodeURIComponent(search) +
        "&departement=" + encodeURIComponent(departement);

      fetch(url, {
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            let rows = '';
            if (data.employees.length === 0) {
              rows = '<tr><td colspan="7" style="text-align:center;padding:20px;">Aucun employé trouvé</td></tr>';
            } else {
              data.employees.forEach(emp => {
                const initials = (emp.prenom ? emp.prenom.charAt(0) : '') + (emp.nom ? emp.nom.charAt(0) :
                  '');
                rows += `
                  <tr id="row_${emp.id}" style="${emp.actif == 0 ? 'opacity:.5' : ''}">
                    <td>
                      <div class="profile-row">
                        <div class="avatar av-green" style="width:32px;height:32px;font-size:.68rem">${initials.toUpperCase()}</div>
                        <div class="profile-info">
                          <div class="pname">${emp.prenom || ''} ${emp.nom || ''}</div>
                          <div class="pdept">${emp.email || ''}</div>
                        </div>
                      </div>
                    </td>
                    <td class="td-muted">${emp.departName || ''}</td>
                    <td><span class="type-badge" style="background:#f1efe8;color:#444441">${emp.role || 'employe'}</span></td>
                    <td class="td-muted td-mono" style="font-size:.78rem">${emp.date_embauche || ''}</td>
                    <td><span class="statut s-approuvee" style="font-size:.68rem">${emp.actif == 1 ? 'actif' : 'inactif'}</span></td>
                    <td><span style="font-family:'DM Mono',monospace;font-size:.82rem;color:var(--forest)">${emp.soldeAnnuelUtilise || 0}/${emp.soldeAnnuelTolal || 0}</span></td>
                    <td>
                      <div class="action-btns">
                        <button class="btn-sm btn-edit"><i class="bi bi-pencil"></i> Éditer</button>
                        <button type="button" class="btn-sm btn-del" onclick="supprimer(${emp.id})"><i class="bi bi-slash-circle"></i> Supprimer</button>
                      </div>
                    </td>
                  </tr>
                `;
              });
            }
            employeesBody.innerHTML = rows;
          }
        })
        .catch(error => console.error('Erreur:', error));
    }

    searchInput.addEventListener("keyup", filterEmployees);
    deptFilter.addEventListener("change", filterEmployees);
  });
</script>

<?= view('partials/foot') ?>