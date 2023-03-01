<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Notificacion extends Mailable
{
    use Queueable, SerializesModels;
    protected $para, $asunto, $cuerpo_mensaje, $archivo;

    public function __construct(){}

    /**
     * @return mixed
     */
    public function getPara()
    {
        return $this->para;
    }

    /**
     * @param mixed $para
     */
    public function setPara($para): void
    {
        $this->para = $para;
    }

    /**
     * @return mixed
     */
    public function getAsunto()
    {
        return $this->asunto;
    }

    /**
     * @param mixed $asunto
     */
    public function setAsunto($asunto): void
    {
        $this->asunto = $asunto;
    }

    /**
     * @return mixed
     */
    public function getCuerpoMensaje()
    {
        return $this->cuerpo_mensaje;
    }

    /**
     * @param mixed $cuerpo_mensaje
     */
    public function setCuerpoMensaje($cuerpo_mensaje): void
    {
        $this->cuerpo_mensaje = $cuerpo_mensaje;
    }

    /**
     * @return mixed
     */
    public function getArchivo()
    {
        return $this->archivo;
    }

    /**
     * @param mixed $archivo
     */
    public function setArchivo($archivo): void
    {
        $this->archivo = $archivo;
    }

    /**
     * @return array
     */
    public function getFrom(): array
    {
        return $this->from;
    }

    /**
     * @param array $from
     */
    public function setFrom(array $from): void
    {
        $this->from = $from;
    }

    /**
     * @return \DateInterval|\DateTimeInterface|int|null
     */
    public function getDelay()
    {
        return $this->delay;
    }

    /**
     * @param \DateInterval|\DateTimeInterface|int|null $delay
     */
    public function setDelay($delay): void
    {
        $this->delay = $delay;
    }



    public function build(){

        $avatar = asset("/images/correo/avatar.png");
        $banner = asset("/images/correo/imagen.png");

        return $this->view('correos.notificacion')
            ->subject($this->asunto)
            ->with([
                "avatar" => $avatar,
                "banner" => $banner,
                "para" => $this->para,
                "cuerpo_mensaje" => $this->cuerpo_mensaje,
                "archivo" => $this->archivo,
            ]);
    }
}
