<div class="row">
  <div class="col-md-12">
    <h2>Doe Sangue.me</h2>

    <div class="container">
      <p>Olá {{ $user->name }}, foi publicada uma nova campanha: {{ $campaign->title }}</p>
      <p>Que vai até: {{ $campaign->expires }}</p>
      <p>Pubicado por: {{ $campaign->author->name }}</p>
    </div>
  </div>
</div>