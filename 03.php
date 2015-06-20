<?php

class YahooWeather
{


    public function __construct($woeid = 851128, $unit = 'c') 
    {
        $this->woeid = $woeid;
        $this->unit = $unit;
        
        /* API & XML podaci */
        $curlobj = curl_init();
        curl_setopt($curlobj, CURLOPT_URL, 'http://weather.yahooapis.com/forecastrss?w='.$this->woeid.'&u='.$this->unit);
        curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, 1);
        $yahooapi = curl_exec($curlobj);
        curl_close($curlobj);   
        
        /* objekt koji sadrzi primljeni XML*/
        $this->weather = new SimpleXMLElement($yahooapi);
        
       
        $this->weather_location = $this->weather->channel->xpath('yweather:location');
        $this->weather_unit = $this->weather->channel->xpath('yweather:units');
       
        $this->weather_atmosphere = $this->weather->channel->xpath('yweather:atmosphere');
        $this->weather_astronomy = $this->weather->channel->xpath('yweather:astronomy');
        $this->weather_condition = $this->weather->channel->item->xpath('yweather:condition');
        $this->weather_forecast = $this->weather->channel->item->xpath('yweather:forecast');
    }
    


/**
 * Weather conditions 
 */
    
    /**
     
     * @return string|int If the unit is shown, the function returns a string.
  
     */ 
    public function getTemperature($showunit = true) 
    {       
        $temperature = (int)$this->weather_condition[0]->attributes()->temp;
        if($showunit) $temperature .= '&#8239;&#176;'.$this->weather_unit[0]->attributes()->temperature;
        
        return $temperature;
    }
    
 
    public function getDescription() 
    {
        
        return $this->weather_condition[0]->attributes()->text;
    }
    
    
    
    public function getLocationCity() 
    {
        
        return $this->weather_location[0]->attributes()->city;
    }
    
   
    public function getLocationCountry() 
    {
        
        return $this->weather_location[0]->attributes()->country;
    }
    
  
    public function getLocationRegion() 
    {
        
        return $this->weather_location[0]->attributes()->region;
    }
    
   
    
    public function getHumidity($showunit = true)
    {
        $humidity = (int)$this->weather_atmosphere[0]->attributes()->humidity;
        if($showunit) $humidity .= '&#37;';
        
        return $humidity;
    }
    
    
   
    public function getVisibility($showunit = true)
    {
        $visibility = (float)$this->weather_atmosphere[0]->attributes()->visibility;
        if($showunit) $visibility .= ' '.$this->weather_unit[0]->attributes()->distance;
        
        return $visibility;
    }

    public function getSunrise($time_format = 'g:i a') 
    {
        $time = new DateTime($this->weather_astronomy[0]->attributes()->sunrise);
        
        return $time->format($time_format);
    }

    public function getSunset($time_format = 'g:i a') 
    {
        $time = new DateTime($this->weather_astronomy[0]->attributes()->sunset);
        
        return $time->format($time_format);
    }
    
    
    

    public function getYahooURL() 
    {
        
        return $this->weather->channel->link;
    }
    
  
    public function getYahooIcon() 
    {
        $weather_description = $this->weather->channel->item->description;
        preg_match_all('/<img[^>]+>/i',$weather_description, $icon);
        
        return $icon[0][0];
    }
    
  
     
    public function getForecastTodayLow($showunit = true) 
    {
        $temperature = $this->weather_forecast[0]->attributes()->low;
        if($showunit) $temperature .= '&#8239;&#176;'.$this->weather_unit[0]->attributes()->temperature;
        
        return $temperature;
    }
    
   
    
    public function getForecastTodayHigh($showunit = true) 
    {
        $temperature = $this->weather_forecast[0]->attributes()->high;
        if($showunit) $temperature .= '&#8239;&#176;'.$this->weather_unit[0]->attributes()->temperature;
        
        return $temperature;
    }
    
    
  
    public function getForecastTodayConditionCode() 
    {
        
        return (int)$this->weather_forecast[0]->attributes()->code;
    }
    
    
    public function getForecastTodayDescription() 
    {
        
        return $this->weather_forecast[0]->attributes()->text;
    }
    
    

    public function getForecastTodayDate($date_format = 'd M Y') 
    {   
        $date = new DateTime($this->weather_forecast[0]->attributes()->date);
        
        return $date->format($date_format);
    }
    
      
}
?>

