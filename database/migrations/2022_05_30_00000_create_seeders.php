<!-- 
create or replace procedure seed_data() LANGUAGE SQL as $$
 insert into "users" 
 ("created_at", 
  "email", 
  "email_verified_at", 
  "name", 
  "password", 
  "remember_token", 
  "role_id", 
  "updated_at") 
  values 
  ('2022-05-30 18:23:39', 'admin@sleepy.com', '2022-05-30 18:23:38', 'Admin', 
   '$2y$10$VnF5pvYZ7RM3VY4BmK1Bi.2ZOc5h3u2irJ2E39dhRk6eF.eanEuJK', 'T0j9r1Gz4A', 
   1, '2022-05-30 18:23:39'), 
   ('2022-05-30 18:23:39', 
	'oferty@sleepy.com', 
	'2022-05-30 18:23:39', 
	'Oferty', 
	'$2y$10$G9jhhdt0MHL6dPR7xvNH8eGym1TMFBTi45FxJ/D3uGF1Xdr4oVklm', 
	'UR1DEaHWbA',
	2, 
	'2022-05-30 18:23:39'), 
	('2022-05-30 18:23:39', 'rezerwacje@sleepy.com', '2022-05-30 18:23:39', 'Rezerwacje', 
	 '$2y$10$iblsR48RzWI0xQpzejVQaecNvPZ6VghHrcoaE44199hvdNbRoIBI.', 'V6uPiSuXiH', 3, '2022-05-30 18:23:39');
	 $$ 
-->

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::select('');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('');
    }
};
