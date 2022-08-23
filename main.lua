function helloWorld()
	local strin = "\nLUA Implementation Is Ready !"
	game.display_message(strin)
end

----------------------EXTERNAL FUNCTIONS
function file_exists(file)
  local f = io.open(file, "rb")
  if f then f:close() end
  return f ~= nil
end
function split(s, delimiter)
    result = {};
    for match in (s..delimiter):gmatch("(.-)"..delimiter) do
        table.insert(result, match);
    end
    return result;
end
-------------------------

function saveGlobalInventory(playerId , instanceId)
	local storageString = ""
	local slot_scene_prop_inventory_count = 199
	local slot_scene_prop_inventory_begin = 200

	local endSlot = game.scene_prop_get_slot(0 , instanceId , 200)
	for i=0,48,1 do
		local index = i + slot_scene_prop_inventory_begin
		local itemId = game.scene_prop_get_slot(0, instanceId, index)
		if storageString == "" then
			storageString = tostring(itemId)
		else
		    storageString = storageString .. "|" .. tostring(itemId)
		end
	end
	local uniqueId = game.player_get_unique_id(0 , playerId)
	file = io.open(tostring(uniqueId)..".ginv", "w")
	file:write(storageString)
	file:close()
end
function loadGlobalInventory(playerId , instanceId)
		-- CONSTANTS --
	local slot_scene_prop_inventory_count = 199
	local slot_scene_prop_inventory_begin = 200
	local uniqueId = game.player_get_unique_id(0,playerId)
	if(file_exists(tostring(uniqueId)..".ginv")) then 
		file = io.open(tostring(uniqueId)..".ginv", "r")
		local storageString = file:read()
		file:close()
		local i = 0
		splitted = split(storageString , "|")
		for key , value in pairs(splitted) do
			local index = i + slot_scene_prop_inventory_begin
			itemId = tonumber(value)
			game.scene_prop_set_slot(instanceId , index , itemId)
			i = i + 1
		end
	else
		for i=0,49,1 do
			local index = i + slot_scene_prop_inventory_begin
			game.scene_prop_set_slot(instanceId , index , 0)
		end
	end
end

function loadChest(instanceId)
	-- CONSTANTS --
	local slot_scene_prop_inventory_count = 199
	local slot_scene_prop_inventory_begin = 200

	local position = game.preg[1]
	local x = tostring(math.floor(position.o.x * 1000))
	local y = tostring(math.floor(position.o.y * 1000))
	local z = tostring(math.floor(position.o.z * 1000))
	game.display_message("[!] Loading " .. x..y..z..".chst")
	if(file_exists(x..y..z..".chst")) then 
		file = io.open(x..y..z..".chst", "r")
		local storageString = file:read()
		file:close()
		local i = 0
		splitted = split(storageString , "|")
		for key , value in pairs(splitted) do
			if value ~= "0" then
				local index = i + slot_scene_prop_inventory_begin
				itemId = tonumber(value)
				game.scene_prop_set_slot(instanceId , index , itemId)
			end
		i = i + 1
		end
	else
		game.display_message("[!] Not Found " .. x..y..z..".chst")
	end
end
function saveChest(instanceId)
	local storageString = ""
	-- CONSTANTS --
	local slot_scene_prop_inventory_count = 199
	local slot_scene_prop_inventory_begin = 200

	local endSlot = game.scene_prop_get_slot(0 , instanceId , 200)
	for i=0,48,1 do
		local index = i + slot_scene_prop_inventory_begin
		local itemId = game.scene_prop_get_slot(0, instanceId, index)
		if storageString == "" then
			storageString = tostring(itemId)
		else
		    storageString = storageString .. "|" .. tostring(itemId)
		end
	end
	local position = game.preg[1]
	local x = tostring(math.floor(position.o.x * 1000))
	local y = tostring(math.floor(position.o.y * 1000))
	local z = tostring(math.floor(position.o.z * 1000))
	file = io.open(x..y..z..".chst", "w")
	file:write(storageString)
	file:close()
end