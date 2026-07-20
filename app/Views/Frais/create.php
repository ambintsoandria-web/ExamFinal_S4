<?= $this->extend('layout/navbar') ?>
<?= $this->section('content') ?>

<div class="auth-page" style="padding: 20px;">
    <div class="auth-shell" style="max-width: 700px; width: 100%; grid-template-columns: 1fr; padding: 40px;">

        <?php if (session('erreur')): ?>
            <div class="alert alert-error">
                <i class="bi bi-exclamation-circle"></i>
                <?= esc(session('erreur')) ?>
            </div>
        <?php endif; ?>

        <div class="login-box" style="max-width: 100%; width: 100%;">

            <div class="login-icon">
                <i class="bi bi-plus-circle" style="font-size: 30px;"></i>
            </div>

            <h2>Ajouter un frais</h2>
            <p class="login-lead">
                Type d'opération : <strong
                    style="color: var(--green-dark);"><?= esc(ucfirst($typeOperation['nom'])) ?></strong>
            </p>

            <form method="post" action="<?= site_url('frais/add') ?>" class="login-form">
                <?= csrf_field() ?>
                <input type="hidden" name="type_operation_id" value="<?= esc($typeOperationId) ?>">

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div>
                        <label for="montant_min">Montant minimum (Ar)</label>
                        <div class="phone-field" style="padding: 0 17px;">
                            <input type="number" id="montant_min" name="montant_min" class="form-input"
                                value="<?= esc(old('montant_min')) ?>" min="0" step="100" placeholder="Ex: 1000"
                                required
                                style="width: 100%; border: none; outline: none; font: 600 15px 'DM Sans'; padding: 16px 0; background: transparent;">
                        </div>
                    </div>

                    <div>
                        <label for="montant_max">Montant maximum (Ar)</label>
                        <div class="phone-field" style="padding: 0 17px;">
                            <input type="number" id="montant_max" name="montant_max" class="form-input"
                                value="<?= esc(old('montant_max')) ?>" min="0" step="100" placeholder="Ex: 5000"
                                required
                                style="width: 100%; border: none; outline: none; font: 600 15px 'DM Sans'; padding: 16px 0; background: transparent;">
                        </div>
                    </div>
                </div>

                <div>
                    <label for="montant_frais">Montant des frais (Ar)</label>
                    <div class="phone-field" style="padding: 0 17px;">
                        <span style="font-weight: 600; font-size: 18px; color: var(--green-dark); margin-right: 12px;">
                            <i class="bi bi-coin"></i>
                        </span>
                        <input type="number" id="montant_frais" name="montant_frais" class="form-input"
                            value="<?= esc(old('montant_frais')) ?>" min="0" step="50" placeholder="Ex: 50" required
                            style="width: 100%; border: none; outline: none; font: 600 15px 'DM Sans'; padding: 16px 0; background: transparent;">
                    </div>
                    <span class="field-help">
                        <i class="bi bi-info-circle"></i> Les frais seront appliqués pour les montants entre <span
                            id="minPreview">0</span> et <span id="maxPreview">0</span> Ar
                    </span>
                </div>

                <div style="display: flex; gap: 12px; margin-top: 30px;">
                    <button type="submit" class="primary-button" style="flex: 1;">
                        <i class="bi bi-save"></i> Enregistrer
                        <span>→</span>
                    </button>
                    <a href="<?= site_url('operateur/operations') ?>" class="primary-button"
                        style="flex: 0.4; background: #f2f6f4; color: var(--ink); box-shadow: none; text-align: center; text-decoration: none; display: flex; align-items: center; justify-content: center;">
                        Annuler
                    </a>
                </div>
            </form>

            <div style="margin-top: 20px; text-align: center; border-top: 1px solid var(--line); padding-top: 20px;">
                <a href="<?= site_url('operateur/operations') ?>"
                    style="color: var(--muted); text-decoration: none; font-weight: 600; font-size: 14px;">
                    <i class="bi bi-arrow-left"></i> Retour à la gestion des opérations
                </a>
            </div>

        </div>
    </div>
</div>

<script>
    document.getElementById('montant_min').addEventListener('input', function () {
        document.getElementById('minPreview').textContent = this.value || 0;
    });
    document.getElementById('montant_max').addEventListener('input', function () {
        document.getElementById('maxPreview').textContent = this.value || 0;
    });
</script>

<style>
    .form-input::placeholder {
        color: #aab5b1;
        font-weight: 400;
    }

    .form-input:focus {
        outline: none;
    }

    .login-form label {
        display: block;
        font-weight: 700;
        font-size: 13px;
        margin: 18px 0 9px;
        color: var(--ink);
    }

    .login-form label:first-of-type {
        margin-top: 0;
    }

    .login-box h2 {
        font-size: 30px;
        margin: 9px 0 10px;
    }

    .login-lead {
        margin-bottom: 20px;
    }

    .primary-button {
        width: 100%;
        height: 56px;
        border: 0;
        border-radius: 13px;
        background: linear-gradient(135deg, #20c684, #0daa6f);
        color: #fff;
        font: 700 15px "DM Sans";
        cursor: pointer;
        margin-top: 24px;
        box-shadow: 0 12px 24px rgba(14, 171, 112, .22);
        transition: transform .2s, box-shadow .2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .primary-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 16px 28px rgba(14, 171, 112, .3);
    }

    .primary-button span {
        margin-right: 4px;
        font-size: 20px;
        line-height: 16px;
    }

    @media (max-width: 600px) {
        .auth-shell {
            padding: 20px !important;
        }

        .login-box h2 {
            font-size: 24px;
        }

        [style*="grid-template-columns: 1fr 1fr"] {
            grid-template-columns: 1fr !important;
            gap: 0 !important;
        }

        [style*="display: flex; gap: 12px"] {
            flex-direction: column;
        }

        .primary-button {
            flex: 1 !important;
        }
    }
</style>

<?= $this->endSection() ?>