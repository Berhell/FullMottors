<?php
require_once '../template/head_sistema.php';
require_once '../classes/CNoticia.php';
require_once '../classes/CImagem.php';

$id = $_GET['id'];

$noticia = new CNoticia;
$img = new CImagem;

//pega a notícia
$consulta = $noticia->getNoticiaId($id);
$num_rows = pg_num_rows($consulta);
$fetch = pg_fetch_object($consulta);

//pega a miniatura relacionada a imagem
$consultaImg = $img->getImgNoticiaId($id);
$num_rows_img = pg_num_rows($consultaImg);
$fetchImg = pg_fetch_object($consultaImg);
?>


<div class="container content">

    <div>
        <legend><h1>Editar Notícia</h1></legend>

        <div class="erro_incluir">

        </div>

        <form  id="noticia_form" class="form-horizontal" action="../operacoes/CNoticia/editar_noticia_op.php" method="post" enctype="multipart/form-data" name="cadastro" >

            <input id="id" type="hidden" value="<?php print $id; ?>" name="id" />


            <div class="control-group">
                <label class="control-label" for="inputManchete"></label>
                <div class="controls">
                    <button type="button" class="btn btn-primary"  data-toggle="modal" href="#modal_img_upload_post">Gerenciamento de Imagens</button>
                    <span class="help-inline" id="foto_miniatura_noticia_legenda"></span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="inputManchete">Manchete</label>
                <div class="controls">
                    <input class="input-xxlarge" type="text" name="manchete" 
                           id="inputManchete" 
                           placeholder="Manchete" 
                           value="<?php print $fetch->manchete ?>">
                </div>
            </div>

            <script type="text/javascript">
                bkLib.onDomLoaded(function() { 
                    var myNicEditor = new nicEditor({
                        iconsPath : '../img/nicEditorIcons.gif',
                        buttonList : ['bold','italic','underline','strikeThrough','image','fontSize','center','justify','right','left','indent','outdent','link','unlink']
                    });
                    myNicEditor.setPanel('editor_controles');
                    myNicEditor.addInstance('edicao_post');
                    
                });
            </script>

            <div class="control-group">
                <label class="control-label" for="inputPost">Post</label>
                <div class="controls">
                    <div id="editor_controles"></div>
                    <div name="post" id="edicao_post"><?php print $fetch->post ?></div>                  
                </div>
            </div>


            <div class="form-actions">
                <a href="view_noticias.php" id="cancelar" type="button" class="btn">Cancelar</a>
                <button id="preview_noticia_btn" type="button" class="btn btn-warning" data-toggle="modal" href="#modal_preview_post">Visualizar Notícia</button>
                <button id="enviar" type="button" class="btn btn-primary">Enviar</button>
            </div>


            <div id="modal_img_upload_post" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Gerenciamento de Imagens</h3>
                </div>
                <div class="modal-body">

                    <h4 id="label_tipo_imagem">Imagem Miniatura da Notícia</h4>


                    <div class="img_produto_container">
                        <?php
                        if ($num_rows_img > 0) {

                            $botao = "<div>
                                <a href='javascript:;' class='btn btn-mini  cancela_deletacao_mini'>Cancelar</a>
                                <a href='javascript:;' class='btn btn-danger btn-mini popover_remove_img_btn'>Deletar</a>
                                </div>";
                            
                            print'<img src="../img/noticias/' . $fetchImg->nome_img . '"/>';
                            print '<a id="foto_miniatura" type="button" class="btn btn-danger btn-mini remove_img" 
                                        data-toggle="popover" 
                                        data-html="true"
                                        title="" data-content="A imagem será 
                                                  apagada imediatamente do sistema. 
                                                    Tem certeza que deseja continuar?' . $botao . '" 
                                        data-original-title="Deletar Imagem">
                                        <i class="icon-remove"></i>
                                  </a>';
                        } else {
                            print '<input id="input_foto" type="file" name="foto_miniatura" />';
                        }
                        ?>
                    </div>                    
                   

                    <?php
                    if ($num_rows_img > 0) {
                        print '<input id="miniatura_modificada" type="hidden" value="0" name="miniatura_modificada" />';
                    } else {
                        print '<input id="miniatura_modificada" type="hidden" value="1" name="miniatura_modificada" />';
                    }
                    ?>

                    <div class="clear"></div>
                </div>
                <div class="modal-footer">
                    <button id="confirma_miniatura_btn" type="button" class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Ok</button>
                </div>
            </div>
        </form>
    </div>


    <div id="modal_preview_post" class="modal hide fade " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Visualização do Post</h3>
        </div>
        <div class="modal-body">

            <div class="coluna8 coluna-inicial">
                <h1>

                </h1>
                <div class="social-likes">
                    <ul>
                        <li>sexta-feira, 01 de março de 2013</li>
                        <li><div class="fb-like fb_edge_widget_with_comment fb_iframe_widget" data-href="" data-send="true" data-layout="button_count" data-width="450" data-show-faces="false" fb-xfbml-state="rendered"><span style="height: 20px; width: 141px;"><iframe id="fd14f3808" name="fc39ea56c" scrolling="no" style="border: none; overflow: hidden; height: 20px; width: 141px;" title="Like this content on Facebook." class="fb_ltr" src="http://www.facebook.com/plugins/like.php?api_key=&amp;locale=pt_BR&amp;sdk=joey&amp;channel_url=http%3A%2F%2Fstatic.ak.facebook.com%2Fconnect%2Fxd_arbiter.php%3Fversion%3D18%23cb%3Df228b0ae1c%26origin%3Dhttp%253A%252F%252Flocalhost%253A8012%252Ff3493a91c8%26domain%3Dlocalhost%26relation%3Dparent.parent&amp;href=http%3A%2F%2Ffmottors.com.br%2Fpaginas%2Fnoticia.php%3Fid%3D4&amp;node_type=link&amp;width=450&amp;layout=button_count&amp;colorscheme=light&amp;show_faces=false&amp;send=true&amp;extended_social_context=false"></iframe></span></div></li>
                    </ul>
                </div>
                <div class="post">

                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Sair</button>            
        </div>
    </div>

</div>

<script type="text/javascript" src="../js/noticias.js"></script>


<?php
require_once '../template/footer_sistema.php';
?>
