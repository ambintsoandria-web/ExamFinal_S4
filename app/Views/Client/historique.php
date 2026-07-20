<?= $this->extend('layout/navbar') ?>
<?= $this->section('content') ?>

<div class="auth-page" style="padding: 20px; min-height: 100vh;">
    <div class="auth-shell" style="max-width: 1000px; width: 100%; grid-template-columns: 1fr; padding: 30px;">

        <!-- Message succès -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success" style="margin-bottom: 20px; font-size: 14px;">
                <i class="bi bi-check-circle"></i>
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <!-- Message erreur -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-error" style="margin-bottom: 20px; font-size: 14px;">
                <i class="bi bi-exclamation-circle"></i>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <div class="login-box" style="max-width: 100%; width: 100%;">
            <div class="login-icon">
                <i class="bi bi-clock-history" style="font-size: 30px;"></i>
            </div>

            <h2 style="font-size: 32px;">Mon historique</h2>
            <p class="login-lead" style="font-size: 16px;">Retrouvez toutes vos transactions effectuées.</p>

            <?php if (!empty($listeHistorique)): ?>
                <div
                    style="max-height: 500px; overflow-y: auto; margin-top: 25px; border-radius: 12px; border: 1px solid var(--line);">
                    <table style="width: 100%; border-collapse: collapse; font-size: 15px; min-width: 600px;">
                        <thead>
                            <tr
                                style="background: #f2f6f4; border-bottom: 2px solid var(--line); position: sticky; top: 0; z-index: 10;">
                                <th
                                    style="padding: 16px 20px; text-align: left; font-weight: 700; color: var(--ink); font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i class="bi bi-tag"></i> Type
                                </th>
                                <th
                                    style="padding: 16px 20px; text-align: right; font-weight: 700; color: var(--ink); font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i class="bi bi-cash"></i> Montant
                                </th>
                                <th
                                    style="padding: 16px 20px; text-align: right; font-weight: 700; color: var(--ink); font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i class="bi bi-receipt"></i> Frais
                                </th>
                                <th
                                    style="padding: 16px 20px; text-align: center; font-weight: 700; color: var(--ink); font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i class="bi bi-calendar3"></i> Date
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($listeHistorique as $transaction): ?>
                                <tr
                                    style="border-bottom: 1px solid var(--line); transition: background 0.2s; hover:background #f8faf9;">
                                    <td style="padding: 16px 20px;">
                                        <?php
                                        $type = $transaction['type'] ?? $transaction['nom'] ?? $transaction['type_operation'] ?? '';

                                        if ($type == 'depot'): ?>
                                            <span
                                                style="color: var(--green-dark); font-weight: 700; font-size: 15px; display: flex; align-items: center; gap: 8px;">
                                                <i class="bi bi-arrow-down-circle" style="font-size: 20px;"></i> Dépôt
                                            </span>
                                        <?php elseif ($type == 'retrait'): ?>
                                            <span
                                                style="color: var(--danger); font-weight: 700; font-size: 15px; display: flex; align-items: center; gap: 8px;">
                                                <i class="bi bi-arrow-up-circle" style="font-size: 20px;"></i> Retrait
                                            </span>
                                        <?php elseif ($type == 'transfert'): ?>
                                            <span
                                                style="color: #f59e0b; font-weight: 700; font-size: 15px; display: flex; align-items: center; gap: 8px;">
                                                <i class="bi bi-arrow-left-right" style="font-size: 20px;"></i> Transfert
                                            </span>
                                        <?php else: ?>
                                            <span style="color: var(--muted); font-weight: 600; font-size: 14px;">
                                                <i class="bi bi-question-circle"></i> <?= esc($type) ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td
                                        style="padding: 16px 20px; text-align: right; font-weight: 700; font-size: 16px; color: var(--ink);">
                                        <?= number_format($transaction['montant'], 0, ',', ' ') ?> <span
                                            style="font-weight: 400; color: var(--muted); font-size: 13px;">Ar</span>
                                    </td>
                                    <td style="padding: 16px 20px; text-align: right; color: var(--muted); font-size: 15px;">
                                        <?php if ($transaction['frais'] > 0): ?>
                                            <span style="color: var(--danger); font-weight: 600;">
                                                <?= number_format($transaction['frais'], 0, ',', ' ') ?> Ar
                                            </span>
                                        <?php else: ?>
                                            <span style="color: var(--green-dark); font-weight: 600;">
                                                <i class="bi bi-check-circle"></i> 0 Ar
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 16px 20px; text-align: center; font-size: 13px; color: var(--muted);">
                                        <i class="bi bi-clock"></i>
                                        <?= date('d/m/Y H:i', strtotime($transaction['date_transaction'])) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Nombre total de transactions -->
                <div style="margin-top: 16px; text-align: right; color: var(--muted); font-size: 13px;">
                    <i class="bi bi-list-ul"></i> Total : <strong><?= count($listeHistorique) ?></strong> transaction(s)
                </div>

            <?php else: ?>
                <div style="text-align: center; padding: 60px 20px; color: var(--muted);">
                    <i class="bi bi-inbox" style="font-size: 64px; display: block; margin-bottom: 16px; opacity: 0.5;"></i>
                    <p style="font-size: 18px; font-weight: 600;">Aucune transaction</p>
                    <p style="font-size: 14px;">Vous n'avez encore effectué aucune opération.</p>
                </div>
            <?php endif; ?>

            <div style="margin-top: 30px; text-align: center; padding-top: 20px; border-top: 1px solid var(--line);">
                <a href="<?= base_url('client/dashboard') ?>"
                    style="color: #fff; background: linear-gradient(135deg, #20c684, #0daa6f); padding: 12px 32px; border-radius: 12px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 10px; transition: all 0.2s; box-shadow: 0 8px 20px rgba(14, 171, 112, 0.25);">
                    <i class="bi bi-arrow-left"></i> Retour au tableau de bord
                </a>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>