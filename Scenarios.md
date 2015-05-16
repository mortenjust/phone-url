# Variables #

Users
  * Frequent traveller
  * Cost-conscious user

Locations
  * Home country
  * Other country
  * Airport
  * Low-coverage area

When
  * Landed in a new country, not switched SIM yet
  * Switched SIM in same country
  * Switched SIM in new country

Has
  * Google Latitude
  * No Google Latitude

# Frequent scenarios #

### Country switcher with local SIM ###
  1. Uses SIM A in country 1
  1. Travels to country 2
  1. Switches to SIM B
Phone URL should: Use Latitude to set active number.

### Country switcher without local SIM ###
  1. Uses SIM A in country 1
  1. Travels to country 2, but does not switch SIM
Phone URL should: Not change active number, even if a country switch has been detected.

### Local SIM switcher ###
  1. Uses SIM a in country 1
  1. Switches to SIM B
Phone URL should: Wait for the user to activate the phone number associated to SIM B