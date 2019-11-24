<?php


namespace app\Model\Response;


class RedirectResponse extends AbstractResponse {
    //TODO проверил , работает
    // отдельно заголовки и HTML - regirect происходит :)
    public function __toString () {
        $this->sendHeaders();
        return $this->getContent();
    }

    public function setUrl($url){
        if (!empty($url)) {
            $this->headers = ['Location' => $url];
            $this->setStatusCode(302);
            $this->setContent($this->redirectContent($url));
        } else {
            throw new \InvalidArgumentException('Cannot redirect empty URL.');
        }
    }
//TODO original taken from symfony framework
    protected function redirectContent($url) {
        $content =
            sprintf('<!DOCTYPE html>
                        <html>
                            <head>
                                <meta charset="UTF-8" />
                                <meta http-equiv="refresh" content="0;url=%1$s" />
                        
                                <title>Redirecting to %1$s</title>
                            </head>
                            <body>
                                Redirecting to <a href="%1$s">%1$s</a>.
                            </body>
                        </html>', htmlspecialchars($url, ENT_QUOTES, 'UTF-8'));
        return $content;
    }

}