<?php

namespace App\Http\Services;

use cebe\markdown\GithubMarkdown;

class ArticleService
{

	/**
	 * Renders the raw article into HTML 
	 * @param string $article - The unformatted article.
	 * @return string 
	 */
    public function renderArticle($article){
    	// Extract code snippets (see: https://regex101.com/r/yUBFUM/1)
        $regex = '/\[code\s?(lang=\"([a-z\.]+)\")?]((.|\n)*?)\[\/code\]/i';
        $snippets = [];
        preg_match_all($regex, $article, $matches);

        // Take each match group and put them into an associative array
        $this->getMatches(0, $matches, $snippets, 'match');
        $this->getMatches(2, $matches, $snippets, 'lang');
        $this->getMatches(3, $matches, $snippets, 'snippet');

        $this->prettifySnippets($snippets);
        // Replace snippets in the article with the pretty printed snippets
        $article = $this->replaceSnippets($snippets, $article);

        // Parse the markdown
        $markdown = new GithubMarkdown();
        $markdown->html5 = true;
         
        return $markdown->parse($article);
    }

     /**
      * Recurseively prettyfies the given snippets using the hilite.me api
      * @param array &$snippets - The array of snippets
      * @param int $current - The current array index 
      */ 
     protected function prettifySnippets(array &$snippets, $current = 0){

        if(count($snippets)){
        	// Default to JavaScript if no language was passed
        	$snippets[$current]['lang'] = (strlen($snippets[$current]['lang']) > 0) ? $snippets[$current]['lang'] : 'JavaScript';

            $lexer = $this->getLexer($snippets[$current]['lang']);
            
            $snippet = $snippets[$current]['snippet'];
	    	$client = new \GuzzleHttp\Client();
	    	$res = $client->request('POST', 'http://hilite.me/api', [
	            'form_params' => [
	            'code' => $snippet, 
	            'linenos' => true,
	            'style' => 'monokai', 
	            'lexer' => $lexer
	            ]
	        ]);
            
            // Pass the actual given language (not $lang), so it can be displayed in the top right hand corner
	        $snippets[$current]['pretty_snippet'] = $this->getPrettySnippet($res->getBody(), $snippets[$current]['lang']);

	        if(($current+1) < count($snippets)){           
	            $this->prettifySnippets($snippets, $current+1);
	        }
        }
    }
 
    /**
     * Returns the language lexer based on the give language. hilite.me doesn't support Vue, so we
     * will need to format this as html. 
     * @param string $lang - The snippet language
     * @return string
     */  
    protected function getLexer($lang){
	    // Single file Vue components format best in HTMl, so use that if language is 'Vue'
	    $lang = (strcasecmp ($lang, "vue.js") == 0 || strcasecmp ($lang, "vue") == 0) ? "html" : $lang;
	    return strtolower($lang);
    }

    /**
     *  Adds additional markup for the returned snippet
     * @param string $html - The html returned from the hilite.me api
     * @param string $lang - The computer language the snippet is written in.
     * @return string
     */ 
    protected function getPrettySnippet($html, $lang){
    	$lang = ($lang ===" javascript") ? "JavaScript" : $lang;
        $html = str_replace("border-width:.1em .1em .1em .8em;", "border-width:0;", $html);
        $html = str_replace("#1e0010", "#272822", $html);

        return '<div class="code-snippet"><div class="ui content segment" style="background: #272822;min-height:50px;">
        <div style="margin-bottom:15px;"><div class="ui top right attached small label">'.$lang.'</div></div>
        '.$html.'
        </div></div>';
    }

    /**
     * Replaces the unformatted snippets in the article with the prettyfied snippets
     * @param array $snippets - The array of snippet
     * @param string article - The unformatted article
     * @return string - The formatted article
     */ 
    protected function replaceSnippets(array $snippets, $article){
         if(count($snippets)){
            foreach($snippets as $snippet){
               $article = str_replace($snippet['match'], $snippet['pretty_snippet'], $article);
            }
         }
         return $article;
    }

    /**
     * Adds the matches at the given index returned from preg_math_all() to an array
     * @param int $index - The index where the matches are found (the match group index)
     * @param array $matches - The matches returned from preg_match_all() 
     * @param array &$arr - The array to add the matches to
     * @param string $key - The key to add the matches to
     */ 
    protected function getMatches($index, array $matches, array &$arr, $key){
        if(count($matches)){
           foreach($matches[$index] as $i=>$match){
              $arr[$i][$key] = $match;
           }
       }
    }
}
