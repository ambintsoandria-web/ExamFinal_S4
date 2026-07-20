<?= view('partials/head', ['title' => 'TechMada RH']) ?>
<?php $formErrors = session()->getFlashdata('errors') ?? []; ?>
<section id="page-form-conge" style="margin-top:3rem">
  <div class="app-wrap">

    <?= view('partials/sidebar', ['activeMenu' => $activeMenu ?? 'dashboard']) ?>

    <div class="main">
      <div class="topbar">
        <div>
          <div class="topbar-title">Nouvelle demande de congé</div>
          <div class="topbar-breadcrumb">
            <a href="/employe">Accueil</a>
            <i class="bi bi-chevron-right" style="font-size:.6rem"></i> Nouvelle demande
          </div>
        </div>
      </div>

      <div class="content">

        <?php if (session()->getFlashdata('erreur')): ?>
          <div class="flash flash-error">
            <i class="bi bi-exclamation-circle-fill"></i>
            <?= esc(session()->getFlashdata('erreur')) ?>
          </div>
        <?php endif; ?>

        <div style="display:grid;grid-template-columns:1fr 300px;gap:1.5rem;align-items:start" class="form-layout">

          <!-- Formulaire principal -->
          <form action="<?= site_url('employe/createDemande') ?>" method="post">
            <?= csrf_field() ?>
            <div>
              <div class="form-section">
                <h3>Détails de la demande</h3>

                <div class="f-group" style="margin-bottom:1rem">
                  <label class="f-label">Type de congé <span style="color:var(--danger)">*</span></label>
                  <select class="f-select" name="typeCongesId" required>
                    <option value="">-- Choisir un type --</option>
                    <?php foreach ($listeType as $type) { ?>
                      <option value="<?= esc($type['id']) ?>" <?= old('typeCongesId') == $type['id'] ? 'selected' : '' ?>>
                        <?= esc($type['libelle'] ?? $type['nom'] ?? 'Type de congé') ?>
                      </option>
                    <?php } ?>
                  </select>
                  <?php if (isset($formErrors['typeCongesId'])): ?>
                    <div class="f-error"><i class="bi bi-exclamation-circle"></i> <?= esc($formErrors['typeCongesId']) ?>
                    </div>
                  <?php endif; ?>
                </div>

                <div class="form-grid-2" style="margin-bottom:1rem">
                  <div class="f-group">
                    <label class="f-label">Date de début <span style="color:var(--danger)">*</span></label>
                    <input type="date" class="f-input" value="<?= esc(old('dateDebut')) ?>" name="dateDebut" required />
                  </div>
                  <div class="f-group">
                    <label class="f-label">Date de fin <span style="color:var(--danger)">*</span></label>
                    <input type="date" class="f-input" value="<?= esc(old('dateFin')) ?>" name="dateFin" required />
                    <?php if (isset($formErrors['dateFin'])): ?>
                      <div class="f-error"><i class="bi bi-exclamation-circle"></i> <?= esc($formErrors['dateFin']) ?>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>

                <!-- Calcul automatique côté PHP (affiché après soumission ou en JS) -->
                <div class="f-computed">
                  <div class="f-computed-num">5</div>
                  <div class="f-computed-label">jours calendaires calculés<br><span
                      style="font-size:.7rem;opacity:.7">du
                      lundi 23 au vendredi 27 juin 2025</span></div>
                </div>

                <div class="f-group" style="margin-bottom:1rem">
                  <label class="f-label">Motif (optionnel)</label>
                  <textarea class="f-textarea" placeholder="Précisez le motif de votre demande si nécessaire..."
                    name="motif"><?= esc(old('motif')) ?></textarea>
                  <div class="f-hint">Le motif est visible par le responsable RH.</div>
                </div>

                <div class="form-actions">
                  <button class="btn-forest" type="submit"><i class="bi bi-send"></i> Soumettre la demande</button>
                  <a href="/employe" class="btn-secondary"><i class="bi bi-x"></i> Annuler</a>
                </div>
              </div>
            </div>
          </form>


          <!-- Panneau latéral : solde & règles -->
          <div style="display:flex;flex-direction:column;gap:1rem">
            <div class="data-card" style="margin:0">
              <div class="data-card-head">
                <h3><i class="bi bi-piggy-bank" style="color:var(--forest);margin-right:5px"></i>Vos soldes actuels</h3>
              </div>
              <div style="padding:.75rem 1.1rem;display:flex;flex-direction:column;gap:.75rem">
                <div>
                  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px">
                    <span style="font-size:.8rem;color:var(--ink)">Congé annuel</span>
                    <span style="font-family:'DM Mono',monospace;font-size:.8rem;color:var(--forest);font-weight:500">18
                      j</span>
                  </div>
                  <div class="solde-bar">
                    <div class="solde-fill" style="width:60%"></div>
                  </div>
                </div>
                <div>
                  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px">
                    <span style="font-size:.8rem;color:var(--ink)">Maladie</span>
                    <span style="font-family:'DM Mono',monospace;font-size:.8rem;color:var(--forest);font-weight:500">8
                      j</span>
                  </div>
                  <div class="solde-bar">
                    <div class="solde-fill" style="width:80%"></div>
                  </div>
                </div>
                <div>
                  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px">
                    <span style="font-size:.8rem;color:var(--ink)">Spécial</span>
                    <span style="font-family:'DM Mono',monospace;font-size:.8rem;color:var(--warn);font-weight:500">1
                      j</span>
                  </div>
                  <div class="solde-bar">
                    <div class="solde-fill warn" style="width:20%"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="flash flash-info" style="margin:0">
              <i class="bi bi-info-circle-fill"></i>
              <span style="font-size:.8rem">Le solde est déduit uniquement à l'approbation de votre responsable.</span>
            </div>
            <div style="background:var(--cream);border:1px solid var(--border);border-radius:8px;padding:.85rem 1rem">
              <div style="font-size:.78rem;font-weight:500;color:var(--ink);margin-bottom:.5rem"><i
                  class="bi bi-clipboard-check" style="color:var(--forest);margin-right:5px"></i>Rappel des règles</div>
              <ul style="margin:0;padding-left:1rem;font-size:.75rem;color:var(--muted);line-height:1.7">
                <li>Préavis minimum : 48h avant la date de début</li>
                <li>Pas de chevauchement avec une demande en cours</li>
                <li>Solde insuffisant = demande refusée automatiquement</li>
              </ul>
            </div>
          </div>

        </div>
      </div>
      <div class="footer-app"><i class="bi bi-c-circle"></i> 2025 <span>TechMada RH</span></div>
    </div>

  </div>
</section>

<?= view('partials/foot') ?>