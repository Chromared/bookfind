<?php
//This file belongs to the BookFind project.
//Copyright (C) 2026 Chromared
//
//This program is free software: you can redistribute it and/or modify
//it under the terms of the GNU Affero General Public License as
//published by the Free Software Foundation, either version 3 of the
//License, or (at your option) any later version.
//
//This program is distributed in the hope that it will be useful,
//but WITHOUT ANY WARRANTY; without even the implied warranty of
//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//GNU Affero General Public License for more details.
//
//You should have received a copy of the GNU Affero General Public License
//along with this program.  If not, see <https://www.gnu.org/licenses/>.

function loanBorrowerHtml(array $loan): string
{
    if (($loan['borrower_name'] ?? '') === 'Deleted user') {
        return htmlspecialchars(bookfind_translate('Deleted user'), ENT_QUOTES, 'UTF-8');
    }

    $profileUrl = url('profile.php?id=' . rawurlencode((string)$loan['borrower_id']));
    return '<a href="' . htmlspecialchars($profileUrl, ENT_QUOTES, 'UTF-8') . '">' .
        htmlspecialchars((string)$loan['borrower_name'], ENT_QUOTES, 'UTF-8') .
        '</a>';
}
